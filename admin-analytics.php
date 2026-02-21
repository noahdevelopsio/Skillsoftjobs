<?php
include("php/session_helper.php");
init_session();
include("php/config.php");

// Ensure only admins can access
if (!isset($_SESSION['valid']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM visitors ORDER BY visited_at DESC LIMIT 100";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head.php"); ?>
    <title>Visitor Analytics | Admin</title>
</head>
<body class="bg-slate-900 font-sans text-slate-300 antialiased selection:bg-brand-500/30 selection:text-brand-200">
    <div class="fixed inset-0 z-[-1] bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-[#0f172a] to-black"></div>
    
    <?php include("includes/navbar.php"); ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 relative z-10">
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 relative">
             <div class="absolute -top-20 -left-20 w-64 h-64 bg-brand-600/20 rounded-full blur-[80px] pointer-events-none"></div>
             <div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-indigo-100 to-indigo-300 tracking-tight flex items-center mb-4">
                    <i class="fa-solid fa-chart-network text-brand-400 mr-4 text-3xl"></i> Visitor Analytics
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl font-medium">Real-time geographical tracking of incoming traffic across the platform.</p>
             </div>
        </div>

        <div class="bg-slate-800/40 backdrop-blur-2xl rounded-3xl border border-slate-700/50 shadow-2xl overflow-hidden relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-brand-500/10 to-violet-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-1000 blur-xl"></div>
            
            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-700/50 bg-slate-900/50">
                            <th class="py-5 px-6 font-bold text-slate-300 uppercase tracking-widest text-xs">Date / Time</th>
                            <th class="py-5 px-6 font-bold text-slate-300 uppercase tracking-widest text-xs">IP Address</th>
                            <th class="py-5 px-6 font-bold text-slate-300 uppercase tracking-widest text-xs">Location</th>
                            <th class="py-5 px-6 font-bold text-slate-300 uppercase tracking-widest text-xs hidden sm:table-cell">Page Visited</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while($visitor = mysqli_fetch_assoc($result)): ?>
                            <tr class="hover:bg-slate-800/60 transition-colors duration-150">
                                <td class="py-4 px-6 text-sm text-slate-300 whitespace-nowrap">
                                    <div class="font-medium text-white"><?php echo date('M d, Y', strtotime($visitor['visited_at'])); ?></div>
                                    <div class="text-slate-500 text-xs"><?php echo date('h:i A', strtotime($visitor['visited_at'])); ?></div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-medium bg-brand-500/10 text-brand-300 border border-brand-500/20 shadow-[0_0_10px_rgba(139,92,246,0.1)]">
                                      <?php echo htmlspecialchars($visitor['ip_address']); ?>
                                    </span>
                                    <div class="text-xs text-slate-500 mt-1 truncate max-w-[150px]" title="<?php echo htmlspecialchars($visitor['isp'] ?? 'Unknown ISP'); ?>">
                                        <?php echo htmlspecialchars($visitor['isp'] ?? 'Unknown ISP'); ?>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center text-sm font-medium text-slate-200">
                                        <i class="fa-solid fa-location-dot text-slate-500 mr-2 text-xs"></i>
                                        <?php echo htmlspecialchars($visitor['city']) . ', ' . htmlspecialchars($visitor['region']); ?>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5 ml-4">
                                        <?php echo htmlspecialchars($visitor['country']) . ' (' . htmlspecialchars($visitor['zip']) . ')'; ?>
                                    </div>
                                </td>
                                <td class="py-4 px-6 hidden sm:table-cell">
                                    <div class="text-sm font-medium text-indigo-300/80 max-w-[200px] truncate" title="<?php echo htmlspecialchars($visitor['page_visited']); ?>">
                                        <?php echo htmlspecialchars($visitor['page_visited']); ?>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5 truncate max-w-[200px]" title="<?php echo htmlspecialchars($visitor['user_agent']); ?>">
                                        <?php echo htmlspecialchars($visitor['user_agent']); ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800/50 text-slate-500 mb-4">
                                        <i class="fa-solid fa-radar text-2xl"></i>
                                    </div>
                                    <p class="text-lg font-medium">No visitor data recorded yet</p>
                                    <p class="text-sm mt-1">Traffic will appear here automatically once users visit the site.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
