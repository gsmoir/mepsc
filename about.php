<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: about.php
 *
 * Description:
 * About the  portal.
 *
 * Features:
 * - Search Manipuri sentences
 * - Search English sentences
 * - Live search (AJAX)
 * - Sentence list
 * - Links to sentence details
 *
 * Technology:
 * - PHP 8+
 * - Bootstrap 5
 * - Vanilla JavaScript
 * ============================================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        About - <?php echo APP_NAME; ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="css/style.css"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</head>

<body>

<div class="container pt-1 pb-4">
    <div class="row">

        <div class="col-lg-10 mx-auto">

            <div class="card shadow search-card">

                <div class="mep-header">

                    <!-- <div class="mep-menu-container">

                        <div class="dropdown">

                            <button
                                class="btn mep-menu-btn"
                                type="button"
                                data-bs-toggle="dropdown">

                                <i class="bi bi-list"></i>

                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a class="dropdown-item" href="about.php">
                                        About MEPSC
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="admin/login.php">
                                        Admin Login
                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div> -->

                    <div class="header-pattern"></div>

                    <div class="row align-items-center">

                        <div class="d-flex justify-content-between align-items-start">

                            <a href="index.php" class="mep-logo">
                                <img src="favicon.png" alt="A description of the image" width="50" height="50"><img>
                            </a>

                            <div class="dropdown">

                                <button
                                    class="btn mep-settings-btn"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                    <i class="bi bi-gear"></i>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end mep-dropdown">
                                    <li>
                                        <a class="dropdown-item" href="index.php">
                                            <i class="bi bi-house-fill me-2"></i>
                                            Home
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="about.php">
                                            <i class="bi bi-info-circle me-2"></i>
                                            About LangdaiTranslate
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="admin/login.php">
                                            <i class="bi bi-person-lock me-2"></i>
                                            Admin Login
                                        </a>
                                    </li>

                                </ul>

                            </div>

                        </div>

                        <!-- <h1 class="mep-title">
                            <?php echo APP_NAME; ?>
                        </h1> -->

                        <p class="mep-title">
                            LangdaiTranslate
                        </p>

                        <div class="mep-badge">
                            A DST Funded Research Project.
                        </div>

                        <!-- <div class="col-lg-8">

                            <div class="mep-logo">
                                Manipuri_English Speech-Text Portal
                            </div>

                            <h1 class="mep-title">
                                
                            </h1>

                            <p class="mep-subtitle">
                                A DST Funded Research Project.
                            </p>

                         <div class="mep-badge">
                                A DST Funded Research Project.
                            </div> 

                        </div> -->

                        <!-- <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                            <a href="admin/login.php"
                               class="btn mep-admin-btn">
                                Admin Login
                            </a>

                        </div> -->
  <!--                       <div class="mep-links">

                            <a href="about.php">About</a>

                            <a href="admin/login.php">Admin</a>

                        </div> -->

                        <!-- <div class="dropdown">

                            <button
                                class="btn mep-menu-btn"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">

                                ☰

                            </button>

                            <ul class="dropdown-menu dropdown-menu-end mep-menu">

                                <li>
                                    <a class="dropdown-item" href="about.php">
                                        About MEPSC
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="admin/login.php">
                                        Admin Login
                                    </a>
                                </li>

                            </ul>

                        </div> -->


                    </div>

                </div>

                <div class="card-body p-5">

                    <h3 class="mb-4">
                        About LangdaiTranslate
                    </h3>

                    <p class="mt-4" style="text-align: justify;">

                        <!--The <strong>Lan gdai Language Corpus (LLC)</strong> is a bilingual speech corpus developed to support research in Natural Language Processing (NLP), Speech Technology, and Artificial Intelligence for the Manipuri (Meiteilon) language. The <strong>LangdaiTranslate</stron is the product of the LLC developed to facilitate English-Manipuri translation through text and speech.
                        -->
                        <strong>Langdai Translate</strong>  is a bilingual Manipuri (Meeteilon)–English translation platform that supports Meetei Mayek, Roman script, and English, with integrated text-to-speech in both languages. It enables users to translate text and instantly listen to the translated output, making communication, language learning, and accessibility easier. As one of the first platforms to combine bidirectional Manipuri–English translation with speech synthesis for both languages, Langdai Translate aims to promote accurate, accessible, and inclusive language technology.
                        <br><br>
                        Developed under a Minor Research Project funded by the Department of Science & Technology (DST), Government of Manipur, the project is led by Dr. Akoijam Malemnganbi (Principal Investigator) and Dr. Leihaorambam Sarbajit Singh, Professor of Linguistics, School of Social Sciences and Humanities, Khongnangthaba University (Co-Principal Investigator). The platform is currently powered by a small, curated bilingual corpus, which is available to researchers and developers interested in Natural Language Processing, translation studies, and related fields. The corpus has been designed to be extensible, allowing new vocabulary, domains, and linguistic resources to be incorporated over time to continually improve the system's coverage and translation quality.

                        <!-- 
                        Dr. Takhellambam Sandhyalata, Assistant Professor, Department of Linguistics, Naorem Birahari College – Translator; 
                        Ms. Silky Chanambam, AIR Imphal – Manipuri Voice Artist; 
                        Ms. Rambha Phairembam, Ph.D. Candidate, Department of Mass Communication, Manipur University – English Voice Artist; 
                        Mr. Gourashyam Moirangthem, Ph.D. Candidate, Department of Computer Science and Engineering, IIIT Manipur – Software Developer; 
                        Mr. Thoungamba Naorem, MA Library and Information Sciences, Manipur University – Corpus Curation, Data Validation, Data Cleaning, and Quality Control. -->


                    </p>

                    <hr class="my-5">

                    <h4>
                        Project team:
                    </h4>

                    <ul class="mt-3">

                        <li>
                            Dr. Akoijam Malemnganbi, Asst. Professor, Dept. of Humanities and Basic Sciences, IIIT Manipur -  Principal Investigator
                        </li>

                        <li>
                            Dr. Leihaorambam Sarbajit Singh, Professor of Linguistics, School of Social Sciences and Humanities, Khongnangthaba University - Co-Principal Investigator
                        </li>

                        <li>
                            Dr. Takhellambam Sandhyalata, Asst. Professor, Dept. of Linguistics, Naorem Birahari College – Translator
                        </li>

                        <li>
                            Ms. Silky Chanambam, AIR Imphal – Manipuri Voice Artist
                        </li>

                        <li>
                            Ms. Rambha Phairembam, Ph.D. Candidate, Dept. of Mass Communication, Manipur University – English Voice Artist
                        </li>

                        <li>
                            Mr. Gourashyam Moirangthem, Ph.D. Candidate, Dept. of Computer Science and Engineering, IIIT Manipur – Software Developer
                        </li>

                        <li>
                            Mr. Thoungamba Naorem, MA Library and Information Sciences, Manipur University – Corpus Curation, Data Validation, Data Cleaning, and Quality Control.
                        </li>

                    </ul>

                    <hr class="my-5">

                    <h4>
                        Applications
                    </h4>

                    <div class="row mt-4">

                        <div class="col-md-6">

                            <div class="mep-detail-item">

                                <div class="mep-label">
                                    Language Technology
                                </div>

                                <div class="mep-value">
                                    Machine Translation, Speech Recognition,
                                    Speech Synthesis, Corpus Linguistics.
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="mep-detail-item">

                                <div class="mep-label">
                                    Artificial Intelligence
                                </div>

                                <div class="mep-value">
                                    Large Language Models, Low-resource NLP,
                                    Data-centric AI and Language Resources.
                                </div>

                            </div>

                        </div>

                    </div>

                    <hr class="my-5">

                    <h4>
                        Project Information
                    </h4>

                    <div class="mep-detail-grid mt-4">

                        <div class="mep-detail-item">

                            <div class="mep-label">
                                Project
                            </div>

                            <div class="mep-value">
                                Langdai Translate
                            </div>

                        </div>

                        <div class="mep-detail-item">

                            <div class="mep-label">
                                Version
                            </div>

                            <div class="mep-value">
                                <?php echo APP_VERSION; ?>
                            </div>

                        </div>

                    </div>

                    <div class="text-center mt-5">

                        <a
                            href="index.php"
                            class="btn btn-primary btn-lg"
                        >
                            <i class="bi bi-search me-2"></i>

                            Search

                        </a>

                    </div>

                </div>

            </div>

            <footer class="mep-footer">

                <div class="row">

                    <div class="col-md-6">

                        <div class="footer-brand">
                            <?php echo APP_NAME; ?>
                        </div>

                        <div class="footer-text">
                            LangdaiTranslate
                        </div>

                    </div>

                    <div class="col-md-6 text-md-end">

                        <div class="footer-version">
                            Version <?php echo APP_VERSION; ?>
                        </div>

                        <div class="footer-copy">
                            © <?php echo date('Y'); ?> MEPSC Research Project
                        </div>

                    </div>

                </div>

            </footer>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>