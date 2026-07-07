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

    <style>
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
    </style>

</head>

<body>

<div class="container py-4">

    <div class="row">

        <div class="col-lg-10 mx-auto">

            <div class="card shadow search-card">

                <div class="card-header bg-primary text-white">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h3 class="mb-0">
                                <?php echo APP_NAME; ?>
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

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">

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
                                <option value="manipuri">
                                    Manipuri
                                </option>

                                <option value="english">
                                    English
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

                    <div class="table-responsive mt-4">

                        <table class="table table-bordered table-hover">

                            <thead class="table-light">

                            <tr>

                                <th style="width:120px;">
                                    Corpus ID
                                </th>

                                <th>
                                    Manipuri
                                </th>

                                <th>
                                    English
                                </th>

                                <th style="width:120px;">
                                    Details
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

                    </div>

                </div>

            </div>

            <div class="card shadow mt-4" id="detailsCard" style="display:none;">

                <div class="card-header bg-secondary text-white">
                    <strong>Sentence Details</strong>
                </div>

                <div class="card-body" id="detailsBody"></div>

            </div>


            <div class="footer text-center">

                <?php echo APP_NAME; ?>
                Version <?php echo APP_VERSION; ?>

            </div>

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

            data.forEach(function (row)
            {
                results.innerHTML +=
                    '<tr class="result-row">' +
                        '<td>' + escapeHtml(row.corpus_id) + '</td>' +
                        '<td>' + escapeHtml(row.manipuri) + '</td>' +
                        '<td>' + escapeHtml(row.english) + '</td>' +
                        '<td>' +
                            '<button class="btn btn-sm btn-primary" onclick="loadSentence(\'' + encodeURIComponent(row.corpus_id) + '\')">View</button>' +
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

function loadSentence(id)
{
    fetch(
        'api/public/sentence.php?format=json&id=' +
        encodeURIComponent(id)
    )
    .then(response => response.json())
    .then(row =>
    {
        document.getElementById('detailsCard').style.display='block';

        document.getElementById('detailsBody').innerHTML =
            '<table class="table table-bordered">' +
            '<tr><th width="180">Corpus ID</th><td>' + escapeHtml(row.corpus_id) + '</td></tr>' +
            '<tr><th>Manipuri</th><td>' + escapeHtml(row.manipuri) + '</td></tr>' +
            '<tr><th>English</th><td>' + escapeHtml(row.english) + '</td></tr>' +
            '<tr><th>Manipuri_Transliterated</th><td>' + escapeHtml(row.remarks ?? '') + '</td></tr>' +
            '<tr><th>Domain</th><td>' + escapeHtml(row.domain ?? '') + '</td></tr>' +
            '<tr><th>Manipuri Audio</th><td><audio controls preload="none"><source src="audio/manipuri/' + row.manipuri_audio + '" type="audio/mpeg"></audio></td></tr>' +
            '<tr><th>English Audio</th><td><audio controls preload="none"><source src="audio/english/' + row.english_audio + '" type="audio/mpeg"></audio></td></tr>' +
            '</table>';

        document.getElementById('detailsCard').scrollIntoView({behavior:'smooth'});
    });
}


function escapeHtml(text)
{
    const div = document.createElement('div');
    div.innerText = text;
    return div.innerHTML;
}

</script>

</body>
</html>