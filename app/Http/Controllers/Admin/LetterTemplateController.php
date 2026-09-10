<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LetterTemplateController extends Controller
{
    /**
     * Allowed MIME types for document upload.
     */
    private array $allowedMimes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    public function index(Request $request)
    {
        $this->authorize('manage_letter_templates');
        $templates = LetterTemplate::latest()->paginate(15);
        return view('admin.letter-templates.index', compact('templates'));
    }

    public function create()
    {
        $this->authorize('manage_letter_templates');
        return view('admin.letter-templates.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage_letter_templates');

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'template_file'=> 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'template_file.required' => 'File template wajib diunggah.',
            'template_file.mimes'    => 'Format file tidak didukung. Gunakan Word (.doc/.docx) atau PDF (.pdf).',
            'template_file.max'      => 'Ukuran file terlalu besar. Maksimal 10 MB.',
        ]);

        $data = [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'content'     => null,
            'created_by'  => Auth::id(),
        ];

        if ($request->hasFile('template_file')) {
            $file        = $request->file('template_file');
            $originalName = $file->getClientOriginalName();
            $extension   = strtolower($file->getClientOriginalExtension());
            $safeName    = Str::uuid() . '.' . $extension;
            $path        = $file->storeAs('letter-templates', $safeName, 'public');

            $data['file_path']      = $path;
            $data['file_name']      = $originalName;
            $data['file_extension'] = $extension;
            $data['mime_type']      = $file->getMimeType();
            $data['file_size']      = $file->getSize();
        }

        $template = LetterTemplate::create($data);

        return redirect()->route('admin.letter-templates.show', $template)
            ->with('success', 'Template surat berhasil disimpan.');
    }

    public function show(LetterTemplate $letter_template)
    {
        $this->authorize('manage_letter_templates');
        return view('admin.letter-templates.show', compact('letter_template'));
    }

    public function edit(LetterTemplate $letter_template)
    {
        $this->authorize('manage_letter_templates');
        return view('admin.letter-templates.edit', compact('letter_template'));
    }

    public function update(Request $request, LetterTemplate $letter_template)
    {
        $this->authorize('manage_letter_templates');

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'template_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'template_file.mimes' => 'Format file tidak didukung. Gunakan Word (.doc/.docx) atau PDF (.pdf).',
            'template_file.max'   => 'Ukuran file terlalu besar. Maksimal 10 MB.',
        ]);

        $data = [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
        ];

        if ($request->hasFile('template_file')) {
            // Delete old file if exists
            if ($letter_template->file_path && Storage::disk('public')->exists($letter_template->file_path)) {
                Storage::disk('public')->delete($letter_template->file_path);
            }

            $file        = $request->file('template_file');
            $originalName = $file->getClientOriginalName();
            $extension   = strtolower($file->getClientOriginalExtension());
            $safeName    = Str::uuid() . '.' . $extension;
            $path        = $file->storeAs('letter-templates', $safeName, 'public');

            $data['file_path']      = $path;
            $data['file_name']      = $originalName;
            $data['file_extension'] = $extension;
            $data['mime_type']      = $file->getMimeType();
            $data['file_size']      = $file->getSize();
        }

        $letter_template->update($data);

        return redirect()->route('admin.letter-templates.show', $letter_template)
            ->with('success', 'Template berhasil diperbarui.');
    }

    public function destroy(LetterTemplate $letter_template)
    {
        $this->authorize('manage_letter_templates');

        // Delete physical file from storage
        if ($letter_template->file_path && Storage::disk('public')->exists($letter_template->file_path)) {
            Storage::disk('public')->delete($letter_template->file_path);
        }

        $letter_template->delete();

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Template berhasil dihapus.');
    }

    public function download(LetterTemplate $letter_template)
    {
        $this->authorize('manage_letter_templates');

        if (!$letter_template->file_path || !Storage::disk('public')->exists($letter_template->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $downloadName = $letter_template->file_name ?? basename($letter_template->file_path);

        return Storage::disk('public')->download($letter_template->file_path, $downloadName);
    }
}