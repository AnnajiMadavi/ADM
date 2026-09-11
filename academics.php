<?php
session_start();

// Protect the page: Kick out unauthorized users
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Details | Economics Library</title>
    <style>
        /* --- Root Variables --- */
        :root {
            --primary-bg: #fdfbf7;
            --header-bg: #1b2a2f;
            --header-light: #2c424a;
            --accent: #c5a86a;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --card-bg: #ffffff;
            --border-color: #e1e4e8;
        }

        /* --- Global Reset --- */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', Arial, sans-serif; background-color: var(--primary-bg); color: var(--text-dark); line-height: 1.6; }
        a { text-decoration: none; }
        .container { max-width: 1000px; margin: 0 auto; padding: 0 1.5rem; }

        /* --- Header & Navigation --- */
        header { background-color: var(--header-bg); color: white; padding: 1.5rem 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid var(--accent); position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin: 0; }
        header p { margin: 5px 0 0 0; color: #a8b8c0; font-size: 0.9rem; }
        
        .user-controls { display: flex; align-items: center; gap: 1rem; }
        .student-badge { background: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 0px; font-size: 0.9rem; border: 2px solid var(--accent); }
        .btn-nav { color: white; border: 1px solid white; padding: 0.5rem 1rem; border-radius: 4px; transition: 0.3s; font-weight: bold; background: rgba(255,255,255,0.1); }
        .btn-logout { color: white; border: 1px solid white; padding: 0.5rem 1rem; border-radius: 4px; transition: 0.3s; font-weight: bold; }
        .btn-nav:hover, .btn-logout:hover { background: var(--accent); border-color: var(--accent); color: var(--header-bg); }

        /* --- Page Title --- */
        .portal-header { margin: 3rem 0 2rem 0; border-bottom: 2px solid var(--border-color); padding-bottom: 1.5rem; }
        .portal-header h2 { color: var(--header-bg); font-family: 'Playfair Display', serif; font-size: 2.2rem; margin: 0 0 10px 0; }
        .portal-header p { color: var(--text-muted); font-size: 1.1rem; }

        /* --- Section Titles --- */
        .section-title { color: var(--header-bg); font-size: 1.5rem; margin: 2.5rem 0 1rem 0; border-left: 5px solid var(--accent); padding-left: 10px; }

        /* --- Accordion (Details/Summary) Styling --- */
        details { background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1rem; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        
        summary { background-color: var(--header-bg); color: #ffffff; padding: 15px 20px; font-size: 1.1rem; font-weight: 600; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; transition: background-color 0.2s ease; }
        summary:hover { background-color: var(--header-light); }
        summary::-webkit-details-marker { display: none; }
        summary::after { content: '+'; font-size: 1.5rem; transition: transform 0.3s; }
        details[open] > summary::after { content: '−'; }
        
        .details-body { padding: 15px 20px; background-color: #fafbfc; }

        /* --- Nested Accordions (For Papers) --- */
        .sub-details { border: 1px solid var(--border-color); margin-bottom: 10px; box-shadow: none; }
        .sub-summary { background-color: #edf2f7; color: var(--header-bg); font-size: 1rem; border-bottom: 1px solid var(--border-color); }
        .sub-summary:hover { background-color: #e2e8f0; }

        /* --- Tables --- */
        table { width: 100%; border-collapse: collapse; background-color: white; border-radius: 6px; overflow: hidden; border: 1px solid #eee; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f8f9fa; }
        td:first-child { font-weight: bold; color: var(--text-dark); width: 70%; }
        td:last-child { text-align: right; width: 30%; }

        /* --- Action Buttons --- */
        .btn-action { display: inline-flex; align-items: center; justify-content: center; background-color: var(--accent); color: white; padding: 8px 16px; border-radius: 5px; font-size: 0.85rem; font-weight: bold; transition: 0.2s; border: 1px solid var(--accent); }
        .btn-action:hover { background-color: #b39556; border-color: #b39556; transform: translateY(-1px); }

        /* --- Animations --- */
        .fade-in { animation: fadeInUp 0.6s ease forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* --- Mobile Responsiveness --- */
        @media (max-width: 768px) {
            header { flex-direction: column; text-align: center; gap: 15px; }
            .user-controls { flex-wrap: wrap; justify-content: center; }
            table, tbody, tr, td { display: block; width: 100%; }
            tr { margin-bottom: 10px; border: 1px solid var(--border-color); border-radius: 6px; padding: 10px; }
            td { text-align: left !important; padding: 8px 0; border-bottom: none; }
            td:first-child { border-bottom: 1px dashed var(--border-color); padding-bottom: 10px; margin-bottom: 10px; }
            .btn-action { width: 100%; padding: 10px; }
        }
    </style>
</head>
<body>

    <header>
        <div>
            <h1>Department of Economics</h1>
            <p> Academic Details | Economics Library</p>
        </div>
        <div class="user-controls">
            <span class="student-badge">Student Name: <?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
            <a href="library.php" class="btn-nav">Economics Library</a>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </header>

    <main class="container">
        <div class="portal-header fade-in">
            <h2>Academic Details</h2>
            <p>Access your syllabus, paper codes, and roll call lists below.</p>
        </div>

        <!-- ==========================================
             SECTION 1: SYLLABUS 
             ========================================== -->
        <h3 class="section-title fade-in" style="animation-delay: 0.1s;"></h3>
        <details class="fade-in" style="animation-delay: 0.2s;" open>
            <summary>B. A. ECONOMICS SYLLABUS</summary>
            <div class="details-body">
                <table>
                    <tr>
                        <td>Semester - I</td>
                        <td><a href="SYllABUS/बी.-ए.-सेमि.-I-अभ्यासक्रम.pdf" class="btn-action">View pdf</a></td>
                    </tr>
                    <tr>
                        <td>Semester - II</td>
                        <td><a href="SYllABUS/बी.-ए.-सेमि.-II-अभ्यासक्रम.pdf" class="btn-action">View pdf</a></td>
                    </tr>
                    <tr>
                        <td>Semester - III</td>
                        <td><a href="SYllABUS/सेमि.-III-अभ्यासक्रम.pdf" class="btn-action">View pdf</a></td>
                    </tr>
                    <tr>
                        <td>Semester - IV</td>
                        <td><a href="SYllABUS/बी. ए. सेमि. IV अभ्यासक्रम.pdf" class="btn-action">View pdf</a></td>
                    </tr>
                    <tr>
                        <td>Semester - V</td>
                        <td><a href="SYllABUS/सेमि.-V-अभ्यासक्रम.pdf" class="btn-action">View pdf</a></td>
                    </tr>
                    <tr>
                        <td>Semester - VI</td>
                        <td><a href="#" class="btn-action">View pdf</a></td>
                    </tr>
                </table>
            </div>
        </details>

        

        <!-- ==========================================
             SECTION 2: STUDENT ROLL NUMBER LIST 
             ========================================== -->
        <h3 class="section-title fade-in" style="animation-delay: 0.7s;"></h3>
        <details class="fade-in" style="animation-delay: 0.8s;">
            <summary>STUDENT ROLL NUMBER & SUBJECT LIST</summary>
            <div class="details-body">
                <table>
                    <tr>
                        <td>B. A. First Year</td>
                        <td><a href="ROLL CALL\2026-27\ROLL CALL B.A. I YEAR.pdf" class="btn-action">View PDF</a></td>
                    </tr>
                    <tr>
                        <td>B. A. Second Year</td>
                        <td><a href="ROLL CALL\2026-27\ROLL CALL B.A. II YEAR.pdf" class="btn-action">View PDF</a></td>
                    </tr>
                    <tr>
                        <td>B. A. Third Year</td>
                        <td><a href="ROLL CALL\2026-27\ROLL CALL B.A. III YEAR.pdf" class="btn-action">View PDF</a></td>
                    </tr>
                </table>
            </div>
        </details>
        <!-- ==========================================
             SECTION 3: ECONOMICS PAPER TITLE AND PAPER CODE 
             ========================================== -->
        <h3 class="section-title fade-in" style="animation-delay: 0.7s;"></h3>
        <details class="fade-in" style="animation-delay: 0.8s;">
            <summary>B.A. ECONOMICS PAPER TITLE AND PAPER CODE</summary>
            <div class="details-body">
                <table>
                    <tr>
                        <td>ECO-PAPER CODE & PAPER TITLE</td>
                        <td><a href="SYllABUS\ECO-PAPER CODE & PAPER TITLE.pdf" class="btn-action">View PDF</a></td>
                    </tr>
                    
                </table>
            </div>
        </details>


       
    </main>

</body>
</html>