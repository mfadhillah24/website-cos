<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — Admin UKM-IT COS</title>
    
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/logo.png')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Navy */
            --navy-950: #040E2A;
            --navy-900: #071A52;
            --navy-800: #0B236B;
            --navy-700: #0D2B85;
            /* Blue */
            --blue-600: #1E88E5;
            --blue-700: #1565C0;
            /* Gray */
            --gray-50:  #F5F7FA;
            --gray-100: #F1F5F9;
            --gray-200: #E2E8F0;
            --gray-300: #CBD5E1;
            --gray-400: #94A3B8;
            --gray-500: #64748B;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1E293B;
            --gray-900: #111827;
            /* Basic */
            --white:    #FFFFFF;
            
            /* Semantic */
            --bg-body: var(--gray-50);
            --border-color: var(--gray-200);
            --text-primary: var(--gray-900);
            --text-secondary: var(--gray-500);
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            font-size: 14px;
        }

        /* ──── SIDEBAR ──── */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--navy-900);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            transition: transform 0.3s ease;
        }
        
        .sidebar-brand {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .brand-icon {
            width: 32px; height: 32px;
            background: var(--white);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .brand-icon svg { width: 18px; height: 18px; fill: var(--navy-900); }
        
        .brand-text-main {
            font-size: 14px;
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
            letter-spacing: 0.5px;
        }
        
        .brand-text-sub {
            font-size: 11px;
            color: var(--gray-400);
            margin-top: 2px;
        }

        .sidebar-nav { flex: 1; padding: 24px 16px; overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none; }
        .sidebar-nav::-webkit-scrollbar { display: none; }
        
        .nav-section-label {
            padding: 0 12px;
            font-size: 11px;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            margin-top: 24px;
        }
        .nav-section-label:first-child { margin-top: 0; }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 6px;
            color: var(--gray-300);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }
        
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; stroke: currentColor; stroke-width: 1.8; fill: none; }
        
        .nav-item:hover {
            background: var(--navy-800);
            color: var(--white);
        }
        
        .nav-item.active {
            background: var(--navy-700);
            color: var(--white);
        }
        .nav-item.active svg { stroke: var(--white); }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* ──── MAIN CONTENT ──── */
        .main-wrapper {
            flex: 1;
            margin-left: 250px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .topbar {
            height: 64px;
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-600);
        }

        .mobile-close {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--white);
        }
        
        .topbar-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .topbar-breadcrumb {
            font-size: 13px;
            color: var(--text-secondary);
            margin-left: 16px;
            padding-left: 16px;
            border-left: 1px solid var(--border-color);
        }
        
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
        }
        
        .user-avatar-sm {
            width: 32px; height: 32px;
            background: var(--gray-100);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
        }
        
        .user-name-sm { font-size: 13px; font-weight: 500; color: var(--gray-800); }
        .user-role-sm { font-size: 11px; color: var(--gray-500); }
        
        .page-content {
            flex: 1;
            padding: 32px;
        }

        /* ──── COMPONENTS ──── */
        
        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert svg { width: 18px; height: 18px; flex-shrink: 0; }
        
        .alert-success {
            background: #ECFDF5;
            border: 1px solid #D1FAE5;
            color: #065F46;
        }
        .alert-success svg { stroke: #10B981; }
        
        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FEE2E2;
            color: #991B1B;
        }
        .alert-error svg { stroke: #EF4444; }

        /* Card */
        .card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
            margin-bottom: 24px;
        }
        
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .card-body { padding: 24px; }
        .card-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            background: var(--gray-50);
            border-radius: 0 0 12px 12px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            height: 38px;
        }
        
        .btn-primary {
            background: var(--navy-900);
            color: var(--white);
        }
        .btn-primary:hover { background: var(--navy-800); }
        
        .btn-secondary {
            background: var(--white);
            border-color: var(--gray-300);
            color: var(--gray-700);
        }
        .btn-secondary:hover { background: var(--gray-50); border-color: var(--gray-400); color: var(--gray-900); }
        
        .btn-accent {
            background: var(--blue-600);
            color: var(--white);
        }
        .btn-accent:hover { background: var(--blue-700); }
        
        .btn-danger {
            background: var(--white);
            border-color: #FECACA;
            color: #DC2626;
        }
        .btn-danger:hover { background: #FEF2F2; border-color: #F87171; }
        
        .btn-warning {
            background: #FFFBEB;
            border-color: #FDE68A;
            color: #92400E;
        }
        .btn-warning:hover { background: #FEF3C7; border-color: #FCD34D; }
        
        .btn-sm { height: 32px; padding: 4px 12px; font-size: 12px; }
        .btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }
        .btn-logout {
            width: 100%;
            background: transparent;
            color: var(--gray-400);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-logout:hover {
            background: rgba(255,255,255,0.05);
            color: var(--white);
        }

        /* Table */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        
        thead th {
            padding: 12px 24px;
            font-size: 12px;
            font-weight: 600;
            color: var(--gray-500);
            border-bottom: 1px solid var(--border-color);
            background: var(--gray-50);
            text-transform: capitalize;
        }
        
        tbody td {
            padding: 16px 24px;
            font-size: 13px;
            border-bottom: 1px solid var(--border-color);
            color: var(--gray-800);
            vertical-align: middle;
        }
        
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: var(--gray-50); }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-blue { background: #EFF6FF; color: var(--blue-700); border: 1px solid #BFDBFE; }
        .badge-green { background: #F0FDF4; color: #15803D; border: 1px solid #BBF7D0; }
        .badge-red { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }
        .badge-gray { background: var(--gray-100); color: var(--gray-700); border: 1px solid var(--gray-200); }
        .badge-yellow { background: #FEFCE8; color: #A16207; border: 1px solid #FEF08A; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 6px;
        }
        
        .form-control {
            width: 100%;
            height: 42px;
            padding: 8px 12px;
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            color: var(--gray-900);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            outline: none;
        }
        
        textarea.form-control { height: auto; padding: 12px; }
        select.form-control { appearance: auto; }
        
        .form-control:focus {
            border-color: var(--blue-600);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-control::placeholder { color: var(--gray-400); }
        .form-control.is-invalid { border-color: #EF4444; }
        .invalid-feedback { font-size: 12px; color: #EF4444; margin-top: 4px; }
        .form-text { font-size: 12px; color: var(--gray-500); margin-top: 4px; }

        /* Utilities */
        .flex { display: flex; }
        .flex-col { display: flex; flex-direction: column; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }
        .gap-6 { gap: 24px; }
        .text-muted { color: var(--text-secondary); }
        .font-semibold { font-weight: 600; }
        .text-sm { font-size: 13px; }
        .text-xs { font-size: 12px; }
        
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

        /* Pagination */
        .pagination { display: flex; gap: 4px; justify-content: flex-end; }
        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border-radius: 6px;
            font-size: 13px;
            color: var(--gray-600);
            text-decoration: none;
            background: var(--white);
            border: 1px solid var(--gray-200);
        }
        .page-link:hover { background: var(--gray-50); color: var(--gray-900); }
        .page-link.active { background: var(--gray-100); border-color: var(--gray-300); color: var(--gray-900); font-weight: 600; }

        /* Responsive */
        @media (max-width: 1024px) {
            .grid-3, .grid-4 { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); height: 100dvh; min-height: 100dvh; }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .mobile-toggle { display: block; }
            .mobile-close { display: block; }
            .topbar-breadcrumb { display: none; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .topbar { padding: 0 16px; }
            .page-content { padding: 16px; }
            .card-header { padding: 16px; }
            .card-body { padding: 16px; }
        }
        
        /* Stat Card */
        .stat-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
        }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--navy-800);
        }
        .stat-icon svg { width: 24px; height: 24px; stroke-width: 1.5; }
        .stat-value {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.2;
        }
        .stat-label { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <?php $orgLogo = \App\Models\Setting::get('org_logo'); ?>
            <div class="brand-icon" style="<?php echo e($orgLogo ? 'background: transparent;' : ''); ?>">
                <?php if($orgLogo): ?>
                    <img src="<?php echo e(asset('images/' . $orgLogo)); ?>" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-layers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
            <div style="flex: 1;">
                <div class="brand-text-main"><?php echo e(\App\Models\Setting::get('org_name', 'UKM-IT COS')); ?></div>
                <div class="brand-text-sub">Management System</div>
            </div>
            <button class="mobile-close" id="mobile-close">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-x'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
            </button>
        </div>

        <nav class="sidebar-nav">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-layout-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Dashboard
            </a>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_members')): ?>
            <div class="nav-section-label">Organisasi</div>
            <a href="<?php echo e(route('admin.members.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.members.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-users'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Data Anggota
            </a>
            <a href="<?php echo e(route('admin.member-statuses.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.member-statuses.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Histori Status
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_periods')): ?>
            <div class="nav-section-label">Kepengurusan</div>
            <a href="<?php echo e(route('admin.periods.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.periods.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-calendar-days'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Periode
            </a>
            <a href="<?php echo e(route('admin.positions.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.positions.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="3"/><path d="M12 8v13M5 21h14"/><path d="M5 13h14"/></svg>
                Jabatan
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_management')): ?>
            <a href="<?php echo e(route('admin.managements.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.managements.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-users'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Struktur Pengurus
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_division')): ?>
            <div class="nav-section-label">Divisi</div>
            <a href="<?php echo e(route('admin.divisions.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.divisions.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-layout-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Manajemen Divisi
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_division_members')): ?>
            <a href="<?php echo e(route('admin.kabid.members.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.kabid.members.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Anggota Bidang
            </a>
            <?php endif; ?>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_programs')): ?>
            <a href="<?php echo e(route('admin.programs.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.programs.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Program Kerja
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_activities')): ?>
            <a href="<?php echo e(route('admin.activities.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.activities.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Kegiatan
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_gallery')): ?>
            <a href="<?php echo e(route('admin.gallery.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.gallery.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Galeri Foto
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage_incoming_letters', 'manage_outgoing_letters', 'manage_letter_templates'])): ?>
            <div class="nav-section-label">Administrasi</div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_incoming_letters')): ?>
            <a href="<?php echo e(route('admin.letters.incoming.index') ?? '#'); ?>" class="nav-item <?php echo e(request()->routeIs('admin.letters.incoming.index') || request()->routeIs('admin.letters.incoming.create') || request()->routeIs('admin.letters.incoming.show') || request()->routeIs('admin.letters.incoming.edit') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-mail'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Surat Masuk
            </a>
            <a href="<?php echo e(route('admin.letters.incoming.archive.index') ?? '#'); ?>" class="nav-item <?php echo e(request()->routeIs('admin.letters.incoming.archive.index') ? 'active' : ''); ?>" style="padding-left:36px; font-size:13px;">
                <svg viewBox="0 0 24 24" style="width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                Arsip Surat Masuk
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_outgoing_letters')): ?>
            <a href="<?php echo e(route('admin.letters.outgoing.index') ?? '#'); ?>" class="nav-item <?php echo e(request()->routeIs('admin.letters.outgoing.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-mail'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Surat Keluar
            </a>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_letter_templates')): ?>
            <a href="<?php echo e(route('admin.letter-templates.index') ?? '#'); ?>" class="nav-item <?php echo e(request()->routeIs('admin.letter-templates.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Template Surat
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage_agendas', 'manage_meetings', 'manage_minutes'])): ?>
            <div class="nav-section-label">Kegiatan & Rapat</div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_agendas')): ?>
            <a href="<?php echo e(route('admin.agendas.index') ?? '#'); ?>" class="nav-item <?php echo e(request()->routeIs('admin.agendas.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-calendar-days'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Agenda Organisasi
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_meetings')): ?>
            <a href="<?php echo e(route('admin.meetings.index') ?? '#'); ?>" class="nav-item <?php echo e(request()->routeIs('admin.meetings.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Rapat Organisasi
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_minutes')): ?>
            <a href="<?php echo e(route('admin.minutes.index') ?? '#'); ?>" class="nav-item <?php echo e(request()->routeIs('admin.minutes.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Notulen Rapat
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_news')): ?>
            <div class="nav-section-label">Publikasi</div>
            <a href="<?php echo e(route('admin.articles.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.articles.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Artikel / Berita
            </a>
            <a href="<?php echo e(route('admin.article-categories.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.article-categories.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                Kategori Artikel
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_announcements')): ?>
            <a href="<?php echo e(route('admin.announcements.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.announcements.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                Pengumuman
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_registration')): ?>
            <div class="nav-section-label">Layanan Publik</div>
            <a href="<?php echo e(route('admin.registrations.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.registrations.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5c-1.1 0-2 .9-2 2v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                Data Pendaftar
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_reports', 'manage_reports', 'review_reports', 'view_org_reports'])): ?>
            <div class="nav-section-label">Laporan</div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_reports')): ?>
            <a href="<?php echo e(route('admin.division-reports.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.division-reports.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Laporan Kegiatan Bidang
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('review_reports')): ?>
            <a href="<?php echo e(route('admin.report-reviews.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.report-reviews.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Review Laporan
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_org_reports')): ?>
            <a href="<?php echo e(route('admin.organization-reports.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.organization-reports.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Rekap Laporan
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_finance')): ?>
            <div class="nav-section-label">Keuangan</div>
            <a href="<?php echo e(route('admin.finances.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.finances.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-credit-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Transaksi Keuangan
            </a>
            <a href="<?php echo e(route('admin.finance-categories.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.finance-categories.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                Kategori Keuangan
            </a>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_rab')): ?>
            <a href="<?php echo e(route('admin.rabs.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.rabs.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-file-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                RAB (Rencana Anggaran Biaya)
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage_users', 'manage_roles', 'manage_settings'])): ?>
            <div class="nav-section-label">Sistem</div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_users')): ?>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                Akun Pengguna
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_roles')): ?>
            <a href="<?php echo e(route('admin.roles.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.roles.*') ? 'active' : ''); ?>">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Role & Permission
            </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage_settings')): ?>
            <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-settings'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Pengaturan
            </a>
            <?php endif; ?>

            <?php if(auth()->user()->can('manage_settings') || auth()->user()->hasRole('Humas')): ?>
            <a href="<?php echo e(route('admin.contacts.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.contacts.*') ? 'active' : ''); ?>">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-mail'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                Pesan Masuk
            </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-logout">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-log-out'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" id="mobile-toggle">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                </button>
                <span class="topbar-title"><?php echo $__env->yieldContent('page_title', 'Dashboard'); ?></span>
                <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                    <span class="topbar-breadcrumb"><?php echo $__env->yieldContent('breadcrumb'); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="topbar-right">
                <!-- NOTIFICATION BELL -->
                <div class="notification-dropdown relative" id="notification-container" style="position: relative;">
                    <button type="button" class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition-colors relative" id="notification-toggle" style="background: none; border: none; cursor: pointer;">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-bell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-gray-600','style' => 'width: 20px; height: 20px; color: #475569;']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <span id="unread-badge" class="absolute flex items-center justify-center min-w-[16px] h-4 px-1 font-bold text-white bg-red-500 rounded-full hidden" style="position: absolute; top: 0px; right: 0px; font-size: 10px; background: #EF4444; color: white; border-radius: 9999px; min-width: 16px; height: 16px; display: none; align-items: center; justify-content: center;">
                            0
                        </span>
                    </button>
                    
                    <!-- Dropdown Content -->
                    <div id="notification-menu" class="absolute right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg hidden flex-col z-50 overflow-hidden" style="position: absolute; right: 0; top: 40px; width: 320px; background: white; border: 1px solid #E2E8F0; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); max-height: 400px; display: none; flex-direction: column; z-index: 50;">
                        <div class="p-3 border-b border-gray-100 flex items-center justify-between bg-gray-50/50" style="padding: 12px; border-bottom: 1px solid #F1F5F9; background: #F8FAFC; display: flex; justify-content: space-between; align-items: center;">
                            <span class="font-semibold text-gray-900 text-sm" style="font-weight: 600; font-size: 14px; color: #111827;">Notifikasi</span>
                            <form action="<?php echo e(route('admin.notifications.mark-all-read')); ?>" method="POST" style="margin:0;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs font-medium text-blue-600 hover:text-blue-700" style="background: none; border: none; cursor: pointer; font-size: 12px; font-weight: 500; color: #2563EB;">Tandai ✓</button>
                            </form>
                        </div>
                        <div id="notification-list" class="flex-1 overflow-y-auto overflow-x-hidden" style="flex: 1; overflow-y: auto; overflow-x: hidden;">
                            <!-- Items inserted by JS -->
                        </div>
                        <div class="p-2 border-t border-gray-100 bg-gray-50 text-center" style="padding: 8px; border-top: 1px solid #F1F5F9; background: #F8FAFC; text-align: center;">
                            <a href="<?php echo e(route('admin.notifications.index')); ?>" class="text-xs font-medium text-blue-600 hover:text-blue-700 block w-full py-1" style="font-size: 12px; font-weight: 500; color: #2563EB; text-decoration: none; display: block;">Lihat Semua →</a>
                        </div>
                    </div>
                </div>

                <div class="user-dropdown-toggle" id="user-dropdown-toggle" style="position: relative;">
                    <div class="flex-col" style="text-align: right;">
                        <div class="user-name-sm"><?php echo e(auth()->user()->name); ?></div>
                        <div class="user-role-sm"><?php echo e(auth()->user()->getRoleNames()->first() ?? 'User'); ?></div>
                    </div>
                    <div class="user-avatar-sm"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></div>
                    
                    <!-- User Dropdown Menu -->
                    <div id="user-dropdown-menu" class="absolute right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg hidden flex-col z-50 overflow-hidden" style="position: absolute; right: 0; top: 100%; width: 200px; background: white; border: 1px solid #E2E8F0; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); display: none; flex-direction: column; z-index: 50;">
                        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" style="width: 100%; padding: 12px 16px; text-align: left; background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #DC2626;">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-log-out'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Keluar Sistem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="page-content">
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                <div class="alert alert-error">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('lucide-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script>
        document.getElementById('mobile-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });
        
        document.getElementById('mobile-close')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('open');
        });

        // User Dropdown Logic
        const userToggle = document.getElementById('user-dropdown-toggle');
        const userMenu = document.getElementById('user-dropdown-menu');
        
        if (userToggle && userMenu) {
            userToggle.addEventListener('click', function(e) {
                if (userMenu.style.display === 'none') {
                    userMenu.style.display = 'flex';
                } else {
                    userMenu.style.display = 'none';
                }
                e.stopPropagation();
            });
            
            document.addEventListener('click', function(e) {
                if (!userMenu.contains(e.target) && !userToggle.contains(e.target)) {
                    userMenu.style.display = 'none';
                }
            });
        }

        // Notification Logic
        document.addEventListener('DOMContentLoaded', function() {
            const notifToggle = document.getElementById('notification-toggle');
            const notifMenu = document.getElementById('notification-menu');
            const notifList = document.getElementById('notification-list');
            const unreadBadge = document.getElementById('unread-badge');
            
            function toggleMenu(e) {
                if (notifMenu.style.display === 'none') {
                    notifMenu.style.display = 'flex';
                    fetchNotifications();
                } else {
                    notifMenu.style.display = 'none';
                }
                e.stopPropagation();
            }

            notifToggle.addEventListener('click', toggleMenu);

            document.addEventListener('click', function(e) {
                if (!notifMenu.contains(e.target) && !notifToggle.contains(e.target)) {
                    notifMenu.style.display = 'none';
                }
            });

            function fetchNotifications() {
                fetch('<?php echo e(route("admin.notifications.fetch")); ?>')
                    .then(res => res.json())
                    .then(data => {
                        updateBadge(data.unreadCount);
                        renderList(data.notifications);
                    });
            }

            function updateBadge(count) {
                if (count > 0) {
                    unreadBadge.textContent = count;
                    unreadBadge.style.display = 'flex';
                } else {
                    unreadBadge.style.display = 'none';
                }
            }

            function renderList(notifications) {
                if (notifications.length === 0) {
                    notifList.innerHTML = '<div style="padding: 16px; text-align: center; font-size: 12px; color: #64748B;">Belum ada notifikasi.</div>';
                    return;
                }

                notifList.innerHTML = notifications.map(n => `
                    <div style="padding: 12px; border-bottom: 1px solid #F8FAFC; transition: background 0.2s; background: ${!n.read_at ? '#EFF6FF' : 'transparent'};">
                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <div style="flex: 1; min-width: 0;">
                                <p style="font-size: 13px; font-weight: 500; color: #111827; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${n.title}</p>
                                <p style="font-size: 12px; color: #64748B; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">${n.message}</p>
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
                                    <span style="font-size: 10px; color: #94A3B8;">${n.created_at_diff}</span>
                                    <a href="/admin/notifications/${n.id}/read" style="font-size: 11px; font-weight: 500; color: #2563EB; text-decoration: none;">
                                        ${n.action_url ? 'Lihat Detail' : (!n.read_at ? 'Tandai Dibaca' : '')}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            // Initial fetch to show badge
            fetchNotifications();
            // Refresh every 60 seconds
            setInterval(fetchNotifications, 60000);
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\SEMESTER 4\PEMROGRAMAN WEB 2\LARAVELL\website-cos\resources\views/layouts/admin.blade.php ENDPATH**/ ?>