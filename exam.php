<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$exam_papers = [
    // Older / CBCS Summer Papers
    [ "subject" => "Macroeconomics", "year" => "2026", "type" => "CBCS PATTERN", "season" => "Summer Exam", "file_url" => "assets/exams/summer_macro_23.pdf" ],
    [ "subject" => "Public Finance", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Summer Exam", "file_url" => "assets/exams/summer_public_22.pdf" ],
    [ "subject" => "Microeconomics Core", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Summer Exam", "file_url" => "assets/exams/summer_micro_24.pdf" ],

    // NEP 2020 - 2025
    [ "subject" => "Paper-I (Indian Economy) HECOCT-IIOI", "year" => "2025", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/NEP(2020)/Paper-I (Indian Economy) HECOCT-IIOI.pdf" ],
    [ "subject" => "Paper-II (Environmental Economics-I) HECOCT-1102", "year" => "2025", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/NEP(2020)/Paper-II (Environmental Economics-I) HECOCT-1102.pdf" ],
    [ "subject" => "Paper-III (Indian Economy-II) HECOCT-1151", "year" => "2025", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/NEP(2020)/Paper-III (Indian Economy-II) HECOCT-1151.pdf" ],
    [ "subject" => "Paper-IV (Environmental Economics-II) HECOCT1152", "year" => "2025", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/NEP(2020)/Paper-IV (Environmental Economics-II) HECOCT1152.pdf" ],
    [ "subject" => "Paper-V Major (Micro Economics-I) HECOCT-1201", "year" => "2025", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/NEP(2020)/Paper-V Major (Micro Economics-I) HECOCT-1201.pdf" ],
    [ "subject" => "Paper-VI Major (Agricultural Economics-I) HECOCT1202", "year" => "2025", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/NEP(2020)/Paper-VI Major (Agricultural Economics-I) HECOCT1202.pdf" ],
    [ "subject" => "Paper-VII Minor (Indian Economics for Competitive Examination) HECOMT-1201", "year" => "2025", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/NEP(2020)/Paper-VII Minor (Indian Economics for Competitive Examination) HECOMT-1201.pdf" ],

    // CBCS - 2025
    [ "subject" => "PAPER-I-Micro Economics", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-I-Micro Economics.pdf" ],
    [ "subject" => "PAPER-II (Economy of Maharashtra)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-II (Economy of Maharashtra).pdf" ],
    [ "subject" => "PAPER-III (Micro Economics-II)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-III (Micro Economics-II).pdf" ],
    [ "subject" => "PAPER-IV (Economy of Maharashtra)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-IV (Economy of Maharashtra).pdf" ],
    [ "subject" => "PAPER-V (Macro Economics-I)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-V (Macro Economics-I).pdf" ],
    [ "subject" => "PAPER-VI (Economics of Development)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-VI (Economics of Development).pdf" ],
    [ "subject" => "PAPER-VIII (Economics of Development and Environment)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-VIII (Economics of Development and Environment).pdf" ],
    [ "subject" => "PAPER-IX (Industrial Economics)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-IX (Industrial Economics).pdf" ],
    [ "subject" => "PAPER-X (Indian Economy)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-X (Indian Economy).pdf" ],
    [ "subject" => "PAPER-XI (International Economics)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-XI (International Economics).pdf" ],
    [ "subject" => "PAPER-XII (Public Finance)", "year" => "2025", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2025/CBCS(OLD)/PAPER-XII (Public Finance).pdf" ],

    // NEP 2020 - 2024
    [ "subject" => "Paper-I (Indian Economy-I) HECOCT–1101", "year" => "2024", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/NEP(2020)/Paper-I (Indian Economy-I) HECOCT–1101.pdf" ],
    [ "subject" => "Paper-II (Environmental Economics-I) HECOCT–1102", "year" => "2024", "type" => "NEP 2020", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/NEP(2020)/Paper-II (Environmental Economics-I) HECOCT–1102.pdf" ],

    // CBCS - 2024
    [ "subject" => "Paper-I Micro Economics", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper-I Micro Economics.pdf" ],
    [ "subject" => "Paper–II Economy of Maharashtra", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper–II Economy of Maharashtra.pdf" ],
    [ "subject" => "Paper–III Micro Economics", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper–III Micro Economics.pdf" ],
    [ "subject" => "Paper–IV Economy of Maharashtra", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper–IV Economy of Maharashtra.pdf" ],
    [ "subject" => "Paper-V Macro Economics", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper-V Macro Economics.pdf" ],
    [ "subject" => "Paper–VI Economics of Development", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper–VI Economics of Development.pdf" ],
    [ "subject" => "Paper–VII Macro Economics", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper–VII Macro Economics.pdf" ],
    [ "subject" => "Paper-VIII Economics of development & Environment", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper-VIII Economics of development & Environment.pdf" ],
    [ "subject" => "Paper-IX Industrial Economics", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper-IX Industrial Economics.pdf" ],
    [ "subject" => "Paper-X Indian Economy", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper-X Indian Economy.pdf" ],
    [ "subject" => "Paper-XI  International Economics", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper-XI  International Economics.pdf" ],
    [ "subject" => "Paper-XI History of Economic Thout", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper-XI History of Economic Thout.pdf" ],
    [ "subject" => "Paper-XII Public Finance", "year" => "2024", "type" => "CBCS PATTERN", "season" => "Winter Exam", "file_url" => "SRTMUN PAPER/WINTER EXAMINATION/WINTER  2024/CBCS(OLD)/Paper-XII Public Finance.pdf" ]
];

$search_query = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
$filtered_papers = [];

if ($search_query !== '') {
    foreach ($exam_papers as $paper) {
        if (
            strpos(strtolower($paper['subject']), $search_query) !== false ||
            strpos(strtolower($paper['year']), $search_query) !== false ||
            strpos(strtolower($paper['type']), $search_query) !== false ||
            strpos(strtolower($paper['season']), $search_query) !== false
        ) {
            $filtered_papers[] = $paper;
        }
    }
} else {
    $filtered_papers = $exam_papers;
}

// Separate papers into NEP 2020 and CBCS pattern groups
$nep_papers = [];
$cbcs_papers = [];

foreach ($filtered_papers as $paper) {
    $year = $paper['year'];
    $season = $paper['season'];
    $type = strtoupper($paper['type']);

    if (strpos($type, 'NEP') !== false) {
        $nep_papers[$year][$season][] = $paper;
    } else {
        $cbcs_papers[$year][$season][] = $paper;
    }
}

krsort($nep_papers);
krsort($cbcs_papers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Exams | Economics Library</title>
    <style>
        :root {
            --primary-bg: #fdfbf7; --header-bg: #1b2a2f; --header-light: #2c424a;
            --accent: #c5a86a; --text-dark: #2c3e50; --text-muted: #6c757d;
            --card-bg: #ffffff; --border-color: #e1e4e8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', Arial, sans-serif; background-color: var(--primary-bg); color: var(--text-dark); line-height: 1.6; }
        a { text-decoration: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem 3rem 1.5rem; }
        
        header { background-color: var(--header-bg); color: white; padding: 1.5rem 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid var(--accent); position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin: 0; }
        header p { margin: 5px 0 0 0; color: #a8b8c0; font-size: 0.9rem; }
        
        .user-controls { display: flex; align-items: center; gap: 1rem; }
        .student-badge { background: rgba(255,255,255,0.1); padding: 0.5rem 1rem; font-size: 0.9rem; border: 2px solid var(--accent); }
        .btn-logout { color: white; border: 1px solid white; padding: 0.5rem 1rem; border-radius: 4px; transition: 0.3s; font-weight: bold; }
        .btn-logout:hover { background: var(--accent); border-color: var(--accent); color: var(--header-bg); }
        
        .portal-header { margin: 2.5rem 0 2rem 0; border-bottom: 2px solid var(--border-color); padding-bottom: 1.5rem; }
        .portal-header h2 { color: var(--header-bg); font-family: 'Playfair Display', serif; font-size: 2.2rem; margin: 0 0 10px 0; }
        
        .search-container { margin-top: 1.5rem; max-width: 600px; }
        .search-form { display: flex; gap: 10px; background: var(--card-bg); padding: 8px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid var(--border-color); }
        .search-form input[type="text"] { flex: 1; border: none; outline: none; padding: 10px; font-size: 1rem; }
        .btn-search { background: var(--header-bg); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-search:hover { background: var(--header-light); }
        .btn-clear { background: #f1f1f1; color: #555; padding: 10px 15px; border-radius: 5px; font-weight: bold; display: flex; align-items: center; }

        .pattern-divider { margin: 3rem 0 1.5rem 0; background: linear-gradient(135deg, var(--header-bg), var(--header-light)); color: #fff; padding: 1.2rem 1.8rem; border-radius: 8px; border-left: 6px solid var(--accent); display: flex; justify-content: space-between; align-items: center; }
        .pattern-divider h2 { font-size: 1.6rem; font-family: 'Playfair Display', serif; letter-spacing: 0.5px; }
        .pattern-badge { background: var(--accent); color: #111; font-weight: bold; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; }

        .exam-year-section { margin-bottom: 2rem; background: var(--card-bg); padding: 1.5rem 2rem 2rem; border-radius: 8px; box-shadow: 0 3px 6px rgba(0,0,0,0.04); border: 1px solid var(--border-color); }
        .academic-year-title { font-size: 1.5rem; color: var(--header-bg); margin: 0 0 1.2rem 0; border-bottom: 2px solid var(--accent); display: inline-block; padding-bottom: 3px; font-family: 'Playfair Display', serif; }
        
        .season-container { display: grid; grid-template-columns: 1fr; gap: 1.5rem; }
        @media(min-width: 768px) { .season-container { grid-template-columns: 1fr 1fr; } }
        
        .exam-list-block { background: #fcfcfc; border-radius: 8px; padding: 1.2rem; border: 1px solid #eee; }
        .exam-list-block h3 { margin-top: 0; font-size: 1.15rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #ccc; font-family: 'DM Sans', sans-serif; }
        
        .paper-list { list-style: none; }
        .paper-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
        .paper-item:last-child { border-bottom: none; }
        .paper-info { display: flex; flex-direction: column; gap: 4px; padding-right: 15px; }
        .paper-subject { font-weight: 600; color: var(--text-dark); font-size: 0.95rem; }
        .paper-type { font-size: 0.75rem; color: var(--text-muted); background: #f0f2f5; padding: 2px 7px; border-radius: 4px; align-self: flex-start; }
        
        .paper-actions { display: flex; gap: 6px; white-space: nowrap; }
        .btn-sm-view, .btn-sm-download { padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; transition: 0.2s; }
        
        .season-summer h3 { color: #d35400; border-bottom-color: #f39c12; }
        .season-summer .btn-sm-view { border: 1px solid #d35400; color: #d35400; }
        .season-summer .btn-sm-view:hover { background: #d35400; color: white; }
        .season-summer .btn-sm-download { background: #d35400; color: white; border: 1px solid #d35400; }
        
        .season-winter h3 { color: #2980b9; border-bottom-color: #3498db; }
        .season-winter .btn-sm-view { border: 1px solid #2980b9; color: #2980b9; }
        .season-winter .btn-sm-view:hover { background: #2980b9; color: white; }
        .season-winter .btn-sm-download { background: #2980b9; color: white; border: 1px solid #2980b9; }

        .no-results { text-align: center; padding: 3rem 2rem; background: white; border-radius: 10px; border: 1px dashed #ccc; color: #666; margin-top: 1.5rem; }
        .fade-in { animation: fadeInUp 0.6s ease forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>SRTMUN Exam Papers</h1>
            <p>Year-Wise Past Papers & Model Answers</p>
        </div>
        <div class="user-controls">
            <span class="student-badge">Student: <?php echo htmlspecialchars($_SESSION['first_name'] ?? 'User'); ?></span>
            <a href="library.php" class="btn-logout" style="background-color: rgba(255,255,255,0.1);">Economics Library</a>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </header>

    <main class="container">
        <div class="portal-header fade-in">
            <h2>Download Question Papers</h2>
            <div class="search-container">
                <form action="" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search subject, year, or season..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button type="submit" class="btn-search">Search</button>
                    <?php if(!empty($search_query)): ?>
                        <a href="exams.php" class="btn-clear">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <?php if (empty($nep_papers) && empty($cbcs_papers)): ?>
            <div class="no-results fade-in">
                <h3>No papers found</h3>
                <p>We couldn't find any exams matching "<strong><?php echo htmlspecialchars($_GET['search']); ?></strong>".</p>
                <a href="exams.php" class="btn-search" style="display: inline-block; text-decoration: none; margin-top: 15px;">View All Papers</a>
            </div>
        <?php else: ?>

            <!-- SECTION 1: NEP 2020 PATTERN -->
            <div class="pattern-divider fade-in">
                <h2>1. NEP 2020 Pattern Question Papers</h2>
                <span class="pattern-badge">NEP 2020</span>
            </div>

            <?php if (!empty($nep_papers)): ?>
                <?php foreach ($nep_papers as $year => $seasons): ?>
                    <section class="exam-year-section fade-in">
                        <h3 class="academic-year-title">Academic Year: <?php echo htmlspecialchars($year); ?></h3>
                        <div class="season-container">
                            
                            <!-- Summer Exam -->
                            <?php if (!empty($seasons['Summer Exam'])): ?>
                                <div class="exam-list-block season-summer">
                                    <h3>Summer Exam</h3>
                                    <ul class="paper-list">
                                        <?php foreach ($seasons['Summer Exam'] as $paper): ?>
                                            <li class="paper-item">
                                                <div class="paper-info">
                                                    <span class="paper-subject"><?php echo htmlspecialchars($paper['subject']); ?></span>
                                                    <span class="paper-type"><?php echo htmlspecialchars($paper['type']); ?></span>
                                                </div>
                                                <div class="paper-actions">
                                                    <a href="<?php echo htmlspecialchars($paper['file_url']); ?>" target="_blank" class="btn-sm-view">View</a>
                                                    <a href="<?php echo htmlspecialchars($paper['file_url']); ?>" download class="btn-sm-download">Download</a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Winter Exam -->
                            <?php if (!empty($seasons['Winter Exam'])): ?>
                                <div class="exam-list-block season-winter">
                                    <h3>Winter Exam</h3>
                                    <ul class="paper-list">
                                        <?php foreach ($seasons['Winter Exam'] as $paper): ?>
                                            <li class="paper-item">
                                                <div class="paper-info">
                                                    <span class="paper-subject"><?php echo htmlspecialchars($paper['subject']); ?></span>
                                                    <span class="paper-type"><?php echo htmlspecialchars($paper['type']); ?></span>
                                                </div>
                                                <div class="paper-actions">
                                                    <a href="<?php echo htmlspecialchars($paper['file_url']); ?>" target="_blank" class="btn-sm-view">View</a>
                                                    <a href="<?php echo htmlspecialchars($paper['file_url']); ?>" download class="btn-sm-download">Download</a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                        </div>
                    </section>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-results" style="margin-bottom: 2rem;">
                    <p>No NEP 2020 pattern question papers available for this search.</p>
                </div>
            <?php endif; ?>


            <!-- SECTION 2: CBCS PATTERN -->
            <div class="pattern-divider fade-in" style="background: linear-gradient(135deg, #23353e, #364e57);">
                <h2>2. CBCS Pattern Question Papers</h2>
                <span class="pattern-badge">CBCS Pattern</span>
            </div>

            <?php if (!empty($cbcs_papers)): ?>
                <?php foreach ($cbcs_papers as $year => $seasons): ?>
                    <section class="exam-year-section fade-in">
                        <h3 class="academic-year-title">Academic Year: <?php echo htmlspecialchars($year); ?></h3>
                        <div class="season-container">
                            
                            <!-- Summer Exam -->
                            <?php if (!empty($seasons['Summer Exam'])): ?>
                                <div class="exam-list-block season-summer">
                                    <h3>Summer Exam</h3>
                                    <ul class="paper-list">
                                        <?php foreach ($seasons['Summer Exam'] as $paper): ?>
                                            <li class="paper-item">
                                                <div class="paper-info">
                                                    <span class="paper-subject"><?php echo htmlspecialchars($paper['subject']); ?></span>
                                                    <span class="paper-type"><?php echo htmlspecialchars($paper['type']); ?></span>
                                                </div>
                                                <div class="paper-actions">
                                                    <a href="<?php echo htmlspecialchars($paper['file_url']); ?>" target="_blank" class="btn-sm-view">View</a>
                                                    <a href="<?php echo htmlspecialchars($paper['file_url']); ?>" download class="btn-sm-download">Download</a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Winter Exam -->
                            <?php if (!empty($seasons['Winter Exam'])): ?>
                                <div class="exam-list-block season-winter">
                                    <h3>Winter Exam</h3>
                                    <ul class="paper-list">
                                        <?php foreach ($seasons['Winter Exam'] as $paper): ?>
                                            <li class="paper-item">
                                                <div class="paper-info">
                                                    <span class="paper-subject"><?php echo htmlspecialchars($paper['subject']); ?></span>
                                                    <span class="paper-type"><?php echo htmlspecialchars($paper['type']); ?></span>
                                                </div>
                                                <div class="paper-actions">
                                                    <a href="<?php echo htmlspecialchars($paper['file_url']); ?>" target="_blank" class="btn-sm-view">View</a>
                                                    <a href="<?php echo htmlspecialchars($paper['file_url']); ?>" download class="btn-sm-download">Download</a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                        </div>
                    </section>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-results">
                    <p>No CBCS pattern question papers available for this search.</p>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </main>
</body>
</html>