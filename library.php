<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$library_resources = [
    [ "title" => "भारतीय अर्थव्यवस्था-भाग ०१", "category" => "भारतीय अर्थव्यवस्था-भाग ०१", "type" => "SEMESTER - I", "year" => "B. A. First Year", "file_url" => "E-BOOKS-NOTES/भारतीय अर्थव्यवस्था-भाग ०१.pdf", "cover_color" => "#1565c0" ],
    [ "title" => "B.A. 1st Year Economics", "category" => "पर्यावरणीय अर्थशास्त्र-भाग-०१", "type" => "SEMESTER - I", "year" => "B. A. First Year", "file_url" => "E-BOOKS-NOTES/पर्यावरणीय अर्थशास्त्र-भाग-०१.pdf", "cover_color" => "#1565c0" ],

    [ "title" => "Principles of Microeconomics", "category" => "भारतीय अर्थव्यवस्था - भाग ०२", "type" => "SEMESTER - II", "year" => "B. A. First Year", "file_url" => "E-BOOKS-NOTES/भारतीय अर्थव्यवस्था - भाग ०२.pdf", "cover_color" => "#1565c0" ],
    [ "title" => "B.A. 1st Year Economics Syllabus", "category" => "पर्यावरणीय अर्थशास्त्र -भाग -०२", "type" => "SEMESTER - II", "year" => "B. A. First Year", "file_url" => "E-BOOKS-NOTES/पर्यावरणीय अर्थशास्त्र -भाग -०२.pdf", "cover_color" => "#1565c0" ],


    [ "title" => "Macroeconomic Policy & Analysis", "category" => "MAJOR - सूक्ष्म अर्थशास्त्र -भाग ०१", "type" => "SEMESTER - III", "year" => "B. A. Second Year", "file_url" => "E-BOOKS-NOTES/MAJOR - सूक्ष्म अर्थशास्त्र -भाग ०१.pdf", "cover_color" => "#2e7d32" ],
    [ "title" => "Public Finance Lecture Notes", "category" => "MAJOR- कृषि अर्थशास्त्र भाग -०१", "type" => "SEMESTER - III", "year" => "B. A. Second Year", "file_url" => "E-BOOKS-NOTES/MAJOR- कृषि अर्थशास्त्र भाग -०१.pdf", "cover_color" => "#2e7d32" ],
    [ "title" => "Macroeconomic Policy & Analysis", "category" => "MINOR-स्पर्धा-परीक्षेसाठी-भारतीय-अर्थशास्त्र", "type" => "SEMESTER - III", "year" => "B. A. Second Year", "file_url" => "E-BOOKS-NOTES/MINOR-स्पर्धा-परीक्षेसाठी-भारतीय-अर्थशास्त्र.pdf", "cover_color" => "#2e7d32" ],
    [ "title" => "Public Finance Lecture Notes", "category" => "MAJOR - सूक्ष्म अर्थशास्त्र - भाग-०२", "type" => "SEMESTER - IV", "year" => "B. A. Second Year", "file_url" => "E-BOOKS-NOTES/MAJOR - सूक्ष्म अर्थशास्त्र - भाग-०२.pdf", "cover_color" => "#2e7d32" ],
    [ "title" => "Public Finance Lecture Notes", "category" => "MAJOR - कृषि अर्थशास्त्र- भाग-०२", "type" => "SEMESTER - IV", "year" => "B. A. Second Year", "file_url" => "E-BOOKS-NOTES/MAJOR - कृषि अर्थशास्त्र- भाग-०२.pdf", "cover_color" => "#2e7d32" ],
    [ "title" => "Public Finance Lecture Notes", "category" => "MINOR-स्पर्धा-परीक्षेचे-बँकिंग", "type" => "SEMESTER - IV", "year" => "B. A. Second Year", "file_url" => "E-BOOKS-NOTES/MINOR-स्पर्धा-परीक्षेचे-बँकिंग.pdf", "cover_color" => "#2e7d32" ],


    [ "title" => "Introductory Econometrics", "category" => "MAJOR - स्थूल  अर्थशास्त्र -भाग ०१", "type" => "SEMESTER - V", "year" => "B. A. Third Year", "file_url" => "E-BOOKS-NOTES/MAJOR - स्थूल  अर्थशास्त्र -भाग ०१.pdf", "cover_color" => "#d35400" ],
    [ "title" => "Introductory Econometrics", "category" => "ELECTVIE -औद्योगिक अर्थशास्त्र", "type" => "SEMESTER - V", "year" => "B. A. Third Year", "file_url" => "E-BOOKS-NOTES/ELECTVIE -औद्योगिक अर्थशास्त्र.pdf", "cover_color" => "#d35400" ],

];

$search_query = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
$filtered_resources = [];

if ($search_query !== '') {
    foreach ($library_resources as $resource) {
        if (strpos(strtolower($resource['title']), $search_query) !== false || strpos(strtolower($resource['category']), $search_query) !== false || strpos(strtolower($resource['type']), $search_query) !== false || strpos(strtolower($resource['year']), $search_query) !== false) {
            $filtered_resources[] = $resource;
        }
    }
} else {
    $filtered_resources = $library_resources;
}

$grouped_resources = [ "B. A. First Year" => [], "B. A. Second Year" => [], "B. A. Third Year" => [] ];
foreach ($filtered_resources as $resource) {
    if (array_key_exists($resource['year'], $grouped_resources)) {
        $grouped_resources[$resource['year']][] = $resource;
    }
}

function getSectionClass($year) {
    if ($year === "B. A. First Year") return "section-first-year";
    if ($year === "B. A. Second Year") return "section-second-year";
    if ($year === "B. A. Third Year") return "section-third-year";
    return "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Economics Library</title>
    <style>
        :root {
            --primary-bg: #fdfbf7; --header-bg: #1b2a2f; --header-light: #2c424a;
            --accent: #c5a86a; --text-dark: #2c3e50; --text-muted: #6c757d;
            --card-bg: #ffffff; --border-color: #e1e4e8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', Arial, sans-serif; background-color: var(--primary-bg); color: var(--text-dark); line-height: 1.6; }
        a { text-decoration: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        
        header { background-color: var(--header-bg); color: white; padding: 1.5rem 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid var(--accent); position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin: 0; }
        header p { margin: 5px 0 0 0; color: #a8b8c0; font-size: 0.9rem; }
        
        .user-controls { display: flex; align-items: center; gap: 1rem; }
        .student-badge { background: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 0px; font-size: 0.9rem; border: 2px solid var(--accent); }
        .btn-logout { color: white; border: 1px solid white; padding: 0.5rem 1rem; border-radius: 4px; transition: 0.3s; font-weight: bold; }
        .btn-logout:hover { background: var(--accent); border-color: var(--accent); color: var(--header-bg); }
        
        .portal-header { margin: 3rem 0 2rem 0; border-bottom: 2px solid var(--border-color); padding-bottom: 1.5rem; }
        .portal-header h2 { color: var(--header-bg); font-family: 'Playfair Display', serif; font-size: 2.2rem; margin: 0 0 10px 0; }
        
        .search-container { margin-top: 1.5rem; max-width: 600px; }
        .search-form { display: flex; gap: 10px; background: var(--card-bg); padding: 8px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid var(--border-color); }
        .search-form input[type="text"] { flex: 1; border: none; outline: none; padding: 10px; font-size: 1rem; }
        .btn-search { background: var(--header-bg); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-search:hover { background: var(--header-light); }
        .btn-clear { background: #f1f1f1; color: #555; padding: 10px 15px; border-radius: 5px; font-weight: bold; }
        
        .year-section { margin-bottom: 4rem; }
        .year-header { font-size: 1.8rem; color: var(--header-bg); border-bottom: 3px solid var(--accent); padding-bottom: 0.5rem; margin-bottom: 1.5rem; display: inline-block; font-family: 'Georgia', serif; }
        
        .library-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem; }
        .book-card { background: var(--card-bg); padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid var(--border-color); border-top: 5px solid var(--accent); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.3s; }
        .book-card:hover { transform: translateY(-5px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        
        .card-tags { display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap; }
        .book-category { color: white; padding: 4px 10px; font-size: 0.75rem; font-weight: bold; border-radius: 4px; text-transform: uppercase; }
        .resource-type { background: #e9ecef; color: #495057; padding: 4px 10px; font-size: 0.75rem; font-weight: bold; border-radius: 4px; border: 1px solid #ced4da; text-transform: uppercase; }
        
        .action-buttons { display: flex; gap: 10px; margin-top: 1.5rem; }
        .btn-view, .btn-download { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 0.6rem; border-radius: 5px; font-size: 0.95rem; font-weight: bold; transition: 0.3s; }
        .btn-view { border: 2px solid var(--header-bg); color: var(--header-bg); }
        .btn-view:hover { background: var(--header-bg); color: white; }
        .btn-download { background: var(--accent); color: white; border: 2px solid var(--accent); }
        .btn-download:hover { background: #b39556; border-color: #b39556; }
        
        .section-first-year .year-header { color: #1565c0; border-bottom-color: #1565c0; }
        .section-first-year .book-card { border-top-color: #1565c0; background: #f4f8ff; }
        .section-first-year .btn-download { background: #1565c0; border-color: #1565c0; }
        .section-first-year .btn-view { border-color: #1565c0; color: #1565c0; }
        
        .section-second-year .year-header { color: #2e7d32; border-bottom-color: #2e7d32; }
        .section-second-year .book-card { border-top-color: #2e7d32; background: #f4fbf5; }
        .section-second-year .btn-download { background: #2e7d32; border-color: #2e7d32; }
        .section-second-year .btn-view { border-color: #2e7d32; color: #2e7d32; }
        
        .section-third-year .year-header { color: #d35400; border-bottom-color: #d35400; }
        .section-third-year .book-card { border-top-color: #d35400; background: #fffcf7; }
        .section-third-year .btn-download { background: #d35400; border-color: #d35400; }
        .section-third-year .btn-view { border-color: #d35400; color: #d35400; }

        .no-results { text-align: center; padding: 4rem 2rem; background: white; border-radius: 10px; border: 1px dashed #ccc; color: #666; margin-top: 2rem; }
        
        .fade-in { animation: fadeInUp 0.8s ease forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        @media (max-width: 768px) {
            header { flex-direction: column; text-align: center; gap: 15px; }
            .user-controls { flex-wrap: wrap; justify-content: center; }
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>Department of Economics</h1>
            <p>Student Academic Portal</p>
        </div>
        <div class="user-controls">
            <span class="student-badge">Student Name: <?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
            <a href="paper.php" class="btn-logout" style="background-color: rgba(255,255,255,0.1);">SRTMUN Exam. Papers</a>
            <a href="academics.php" class="btn-logout" style="background-color: rgba(255,255,255,0.1);">Academics Info</a>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </header>

    <main class="container">
        <div class="portal-header fade-in">
            <h2>Available Digital Resources</h2>
            <p>Select a resource below to view it directly in your browser or download it for offline study.</p>
            
            <div class="search-container">
                <form action="library.php" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search by year, category, or type..." value="<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                    <button type="submit" class="btn-search">Search</button>
                    <?php if(!empty($search_query)): ?>
                        <a href="library.php" class="btn-clear">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <?php if (count($filtered_resources) > 0): ?>
            <?php foreach (['B. A. First Year', 'B. A. Second Year', 'B. A. Third Year'] as $year): ?>
                <?php if (count($grouped_resources[$year]) > 0): ?>
                    <section class="year-section fade-in <?php echo getSectionClass($year); ?>">
                        <h2 class="year-header"><?php echo $year; ?></h2>
                        <div class="library-grid">
                            <?php foreach ($grouped_resources[$year] as $resource): ?>
                                <div class="book-card">
                                    <div class="card-tags">
                                        <span class="book-category" style="background-color: <?php echo $resource['cover_color']; ?>">
                                            <?php echo $resource['category']; ?>
                                        </span>
                                        <span class="resource-type">
                                            <?php echo $resource['type']; ?>
                                        </span>
                                    </div>
                                    <div class="action-buttons">
                                        <a href="<?php echo $resource['file_url']; ?>" target="_blank" class="btn-view">View</a>
                                        <a href="<?php echo $resource['file_url']; ?>" download class="btn-download">Download</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-results fade-in">
                <h3>No resources found</h3>
                <p>We couldn't find anything matching "<strong><?php echo htmlspecialchars($_GET['search']); ?></strong>".</p>
                <a href="library.php" class="btn-search" style="display: inline-block; text-decoration: none; margin-top: 15px;">View All Resources</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>