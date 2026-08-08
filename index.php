<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: index.php
 *
 * Description:
 * Public search portal.
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

    <title><?php echo APP_NAME; ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="css/style.css"
    >

    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="favicon.png">
    <!-- <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon.png">
    <link rel="apple-touch-icon" href="assets/images/apple-touch-icon.png"> -->


<!--     <style>
        body {
            background: #f8f9fa;
        }

        .search-card {
            margin-top: 40px;
        }

        .result-row:hover {
            background: #f8f9fa;
        }

        #loading {
            display: none;
        }

        .footer {
            margin-top: 60px;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style> -->

</head>

<body>

<!-- <div class="container py-4"> -->
<div class="container pt-1 pb-4">
    <div class="row">

        <div class="col-lg-10 mx-auto">

            <div class="card shadow search-card">

                <!-- <div class="card-header bg-primary text-white">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h3 class="mb-0">
                            </h3>

                            <small>
                                Manipuri–English Parallel Speech Corpus
                            </small>

                        </div>

                        <div>

                            <a
                                href="admin/login.php"
                                class="btn btn-light btn-sm"
                            >
                                Admin Login
                            </a>

                        </div>

                    </div>

                </div> -->

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

                            <!-- <a href="index.php" class="mep-logo">
                                LangdaiTranslate
                            </a> -->
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
                            Langdai Translate
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
                                        About LangdaiTranslate
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

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-3">

                            <label
                                for="searchType"
                                class="form-label"
                            >
                                Search In
                            </label>

                            <select
                                id="searchType"
                                class="form-select"
                            >
                                <option value="english">
                                    English
                                </option>
                                <option value="manipuri">
                                    Manipuri/Meeteilon (Meetei Mayek)
                                </option>
                                <option value="remarks">
                                    Manipuri/Meeteilon (Roman Script)
                                </option>



                            </select>

                        </div>

                        <div class="col-md-8">

                            <label
                                for="searchText"
                                class="form-label"
                            >
                                Search
                            </label>

                            <input
                                type="text"
                                id="searchText"
                                class="form-control"
                                placeholder="Start typing..."
                                autocomplete="off"
                            >

                        </div>

                    </div>

                    <div
                        id="loading"
                        class="mt-3"
                    >
                        <div
                            class="spinner-border spinner-border-sm text-primary"
                            role="status"
                        ></div>

                        Searching...
                    </div>

                    <!-- <div class="table-responsive mt-5">

                        <table class="table table-bordered table-hover">

                            <thead class="table-light">

                            <tr>

                                <th style="width:120px;">
                                    Corpus ID
                                </th>


                                <th>
                                    Please Choose a Word or Sentence
                                </th>

                                <th >
                                    View
                                </th>

                            </tr>

                            </thead>

                            <tbody id="results">

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center text-muted"
                                >
                                    Type to search...
                                </td>

                            </tr>

                            </tbody>

                        </table>

                    </div> -->

                    <div class="table-responsive mep-results mt-4">

                        <table class="table align-middle mb-0">

                            <thead>

                                <tr>

                                    <th id="searchHeader">
                                        Please Choose a Word or Sentence
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="results">

                                <tr>

                                    <td class="mep-empty-state">
                                        Type to search...
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- <div class="card shadow mt-4" id="detailsCard" style="display:none;">

                <div class="card-header bg-secondary text-white">
                    <strong>Sentence Details</strong>
                </div>

                <div class="card-body" id="detailsBody"></div>

            </div> -->

            <div class="card mep-details-card mt-4" id="detailsCard" style="display:none;">

                <div class="mep-details-header">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="mep-details-title">
                                Text and Speech Translation
                            </div>

                            <div class="mep-details-subtitle">
                                Corpus information and audio resources
                            </div>

                        </div>

                    </div>

                </div>

                <div class="card-body mep-details-body" id="detailsBody"></div>

            </div>


            <!-- <div class="footer text-center">

                <?php echo APP_NAME; ?>
                Version <?php echo APP_VERSION; ?>

            </div> -->

            <footer class="mep-footer">

                <div class="row">

                    <div class="col-md-6">

                        <div class="footer-brand">
                            <?php echo APP_NAME; ?>
                        </div>

                        <div class="footer-text">
                            Manipuri-English Parallel Speech Corpus
                        </div>

                    </div>

                    <div class="col-md-6 text-md-end">

                        <div class="footer-version">
                            Version <?php echo APP_VERSION; ?>
                        </div>

                        <div class="footer-copy">
                            © <?php echo date('Y'); ?> LangdaiTranslate Research Project
                        </div>

                    </div>

                </div>

            </footer>

        </div>

    </div>

</div>

<script>

const searchBox = document.getElementById('searchText');
const searchType = document.getElementById('searchType');
const loading = document.getElementById('loading');
const results = document.getElementById('results');

let timer = null;

searchBox.addEventListener('keyup', performSearch);
searchType.addEventListener('change', performSearch);

function performSearch()
{
    clearTimeout(timer);

    timer = setTimeout(function ()
    {
        const keyword = searchBox.value.trim();

        if (keyword.length === 0)
        {
            results.innerHTML =
                '<tr>' +
                '<td colspan="4" class="text-center text-muted">' +
                'Type to search...' +
                '</td>' +
                '</tr>';

            return;
        }

        loading.style.display = 'block';

        fetch(
            'api/public/search.php?q=' +
            encodeURIComponent(keyword) +
            '&field=' +
            encodeURIComponent(searchType.value)
        )
        .then(response => response.json())
        .then(data =>
        {
            loading.style.display = 'none';

            results.innerHTML = '';

            if (data.length === 0)
            {
                results.innerHTML =
                    '<tr>' +
                    '<td colspan="4" class="text-center text-danger">' +
                    'No matching records found.' +
                    '</td>' +
                    '</tr>';

                return;
            }

            // data.forEach(function (row)
            // {
            //     results.innerHTML +=
            //         '<tr class="result-row">' +
            //             '<td>' + escapeHtml(row.english) + '</td>' +
            //             '<td>' + escapeHtml(row.manipuri) + '</td>' +
            //             '<td>' +
            //                 '<button class="mep-view-btn" onclick="loadSentence(\'' + encodeURIComponent(row.corpus_id) + '\')">View</button>' +
            //             '</td>' +
            //         '</tr>';
            // });

            // data.forEach(function (row)
            // {
            //     const displayText = (searchType.value === 'english')
            //         ? row.english
            //         : row.manipuri;

            //     results.innerHTML +=
            //         '<tr class="result-row">' +
            //             '<td>' + escapeHtml(displayText) + '</td>' +
            //             '<td>' +
            //                 '<button class="mep-view-btn" onclick="loadSentence(\'' + encodeURIComponent(row.corpus_id) + '\')">View</button>' +
            //             '</td>' +
            //         '</tr>';
            // });

            data.forEach(function (row)
            {
                // const displayText = (searchType.value === 'english')
                //     ? row.english
                //     : row.manipuri;

                let displayText;

                if(searchType.value === 'english')
                {
                    displayText = row.english;
                }
                else if(searchType.value === 'remarks')
                {
                    displayText = row.remarks;
                }
                else
                {
                    displayText = row.manipuri;
                }

                results.innerHTML +=
                    '<tr class="result-row">' +
                        '<td class="mep-clickable" onclick="loadSentence(\'' + encodeURIComponent(row.corpus_id) + '\')">' +
                            escapeHtml(displayText) +
                        '</td>' +
                    '</tr>';
            });

        })
        .catch(function ()
        {
            loading.style.display = 'none';

            results.innerHTML =
                '<tr>' +
                '<td colspan="4" class="text-center text-danger">' +
                'Unable to perform search.' +
                '</td>' +
                '</tr>';
        });

    }, 250);
}

// function loadSentence(id)
// {
//     fetch(
//         'api/public/sentence.php?format=json&id=' +
//         encodeURIComponent(id)
//     )
//     .then(response => response.json())
//     .then(row =>
//     {
//         document.getElementById('detailsCard').style.display='block';

//         document.getElementById('detailsBody').innerHTML =
//             '<table class="table table-bordered">' +
//             '<tr><th width="180">Corpus ID</th><td>' + escapeHtml(row.corpus_id) + '</td></tr>' +
//             '<tr><th>Manipuri</th><td>' + escapeHtml(row.manipuri) + '</td></tr>' +
//             '<tr><th>English</th><td>' + escapeHtml(row.english) + '</td></tr>' +
//             '<tr><th>Manipuri_Transliterated</th><td>' + escapeHtml(row.remarks ?? '') + '</td></tr>' +
//             '<tr><th>Domain</th><td>' + escapeHtml(row.domain ?? '') + '</td></tr>' +
//             '<tr><th>Manipuri Audio</th><td><audio controls preload="none"><source src="audio/manipuri/' + row.manipuri_audio + '" type="audio/mpeg"></audio></td></tr>' +
//             '<tr><th>English Audio</th><td><audio controls preload="none"><source src="audio/english/' + row.english_audio + '" type="audio/mpeg"></audio></td></tr>' +
//             '</table>';

//         document.getElementById('detailsCard').scrollIntoView({behavior:'smooth'});
//     });
// }


// function loadSentence(id)
// {
//     fetch(
//         'api/public/sentence.php?format=json&id=' +
//         encodeURIComponent(id)
//     )
//     .then(response => response.json())
//     .then(row =>
//     {
//         document.getElementById('detailsCard').style.display='block';

//         document.getElementById('detailsBody').innerHTML =
//             '<table class="table table-bordered">' +
//             '<tr><th width="180">ID: </th><td>' + escapeHtml(row.corpus_id) + '</td></tr>' +
//             '<tr><th>English: </th><td>' + escapeHtml(row.english)+"  " +'<audio id="audio_e"><source src="audio/english/' + row.english_audio + '" type="audio/mpeg"></audio><button onclick="playAudioE()">🔊</button></td></tr>' +
//             '<tr><th>Manipuri: </th><td>' + escapeHtml(row.manipuri) +"  " +'<audio id="audio_m"><source src="audio/manipuri/' + row.manipuri_audio + '" type="audio/mpeg"></audio><button onclick="playAudioM()">🔊</button></td></tr>' +
//             '<tr><th></th><td>' + escapeHtml(row.remarks ?? '') +'</td></tr>' +
//             '<tr><th>Type: </th><td>' + escapeHtml(row.domain ?? '') +"  " + '</td></tr>' +
//             // '<tr><th>Manipuri Audio</th><td><audio id="audio_m"><source src="audio/manipuri/' + row.manipuri_audio + '" type="audio/mpeg"></audio><button onclick="playAudioM()">🔊</button></td></tr>' +
//             // '<tr><th>English Audio</th><td><audio id="audio_e"><source src="audio/english/' + row.english_audio + '" type="audio/mpeg"></audio><button onclick="playAudioE()">🔊</button></td></tr>' +
//             '</table>';

//         document.getElementById('detailsCard').scrollIntoView({behavior:'smooth'});
//     });
// }


function loadSentence(id)
{
    fetch(
        'api/public/sentence.php?format=json&id=' +
        encodeURIComponent(id)
    )
    .then(response => response.json())
    .then(row =>
    {
        document.getElementById('detailsCard').style.display = 'block';

        document.getElementById('detailsBody').innerHTML =

            '<div class="mep-detail-grid">' +

                

                '<div class="mep-detail-item">' +
                    '<div class="mep-label">English</div>' +
                    '<div class="mep-value">' +

                        '<span>' +
                        escapeHtml(row.english) +
                        '</span>' +

                        '<audio id="audio_e">' +
                            '<source src="audio/english/' +
                            row.english_audio +
                            '" type="audio/mpeg">' +
                        '</audio>' +

                        '<button class="mep-audio-btn" onclick="playAudioE()">🔊</button>' +

                    '</div>' +
                '</div>' +

                '<div class="mep-detail-item">' +
                    '<div class="mep-label">Manipuri</div>' +
                    '<div class="mep-value">' +

                        '<span>' +
                        escapeHtml(row.manipuri) +
                        '</span>' +

                        '<audio id="audio_m">' +
                            '<source src="audio/manipuri/' +
                            row.manipuri_audio +
                            '" type="audio/mpeg">' +
                        '</audio>' +

                        '<button class="mep-audio-btn" onclick="playAudioM()">🔊</button>' +

                    '</div>' +
                '</div>' +
                '<div class="mep-detail-item">' +
                    '<div class="mep-label">Manipuri</div>' +
                    '<div class="mep-value">' +

                        '<span>' +
                        escapeHtml(row.remarks) +
                        '</span>' +

                        '<audio id="audio_m">' +
                            '<source src="audio/manipuri/' +
                            row.manipuri_audio +
                            '" type="audio/mpeg">' +
                        '</audio>' +

                        '<button class="mep-audio-btn" onclick="playAudioM()">🔊</button>' +

                    '</div>' +
                '</div>' +
                // '<div class="mep-detail-item">' +
                //     '<div class="mep-label">Transliteration</div>' +
                //     '<div class="mep-value">' +
                //         escapeHtml(row.remarks ?? '') +
                //     '</div>' +
                // '</div>' +

                '<div class="mep-detail-item">' +
                    '<div class="mep-label">Corpus Details</div>' +
                    '<div class="mep-value">' +
                        'ID: '+escapeHtml(row.corpus_id ?? '') +
                    '</div>' +
                '<div class="mep-value">' +
                        'Domain: '+escapeHtml(row.domain ?? '') +
                    '</div>' +
                '</div>' +
// '<div class="mep-detail-item">' +
//                     '<div class="mep-label">Sentence ID</div>' +
//                     '<div class="mep-value">' +
//                         escapeHtml(row.corpus_id) +
//                     '</div>' +
//                 '</div>' +
            '</div>';

        document
            .getElementById('detailsCard')
            .scrollIntoView({
                behavior:'smooth',
                block:'start'
            });
    });
}

function escapeHtml(text)
{
    const div = document.createElement('div');
    div.innerText = text;
    return div.innerHTML;
}

function playAudioM() {
  // var audio = document.getElementById("audio_m");
  const m = document.getElementById("audio_m");
  const e = document.getElementById("audio_e");

  e.pause();
  e.cuurentTime = 0;
  
  if (m.paused) {
    m.play();
  } else {
    m.pause();
    m.currentTime=0;
  }
}

function playAudioE() {
  // var audio = document.getElementById("audio_e");
  const m = document.getElementById("audio_m");
  const e = document.getElementById("audio_e");

  m.pause();
  m.cuurentTime = 0;
  
  if (e.paused) {
    e.play();
  } else {
    e.pause();
    e.currentTime=0;
  }
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>