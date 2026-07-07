<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: admin/index.php
 *
 * Description:
 * Administrator Dashboard
 *
 * Features
 * --------
 * - Login protected
 * - Corpus statistics
 * - Add new sentence
 * - Edit existing sentence
 * - Delete sentence
 * - Import CSV
 * - Search corpus
 *
 * Technology
 * ----------
 * - PHP 8+
 * - PDO SQLite
 * - Bootstrap 5
 * - Vanilla JavaScript
 * ============================================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/auth.php';

requireAdminLogin();

/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/
$totalSentences = (int)$pdo
    ->query("SELECT COUNT(*) FROM sentence_pairs")
    ->fetchColumn();

$totalSpeakers = (int)$pdo
    ->query("
        SELECT COUNT(DISTINCT speaker_id)
        FROM sentence_pairs
        WHERE speaker_id IS NOT NULL
          AND speaker_id <> ''
    ")
    ->fetchColumn();

$totalDomains = (int)$pdo
    ->query("
        SELECT COUNT(DISTINCT domain)
        FROM sentence_pairs
        WHERE domain IS NOT NULL
          AND domain <> ''
    ")
    ->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>MEPSC Administration</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="mb-0">
                MEPSC Administration
            </h2>

            <small class="text-muted">
                Manipuri-English Parallel Speech Corpus
            </small>

        </div>

        <div>

            <a
                href="../index.php"
                class="btn btn-outline-primary"
            >
                Public Portal
            </a>

            <a
                href="logout.php"
                class="btn btn-outline-danger"
            >
                Logout
            </a>

        </div>

    </div>

    <!-- =============================================================== -->
    <!-- Statistics -->
    <!-- =============================================================== -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Sentences
                    </h6>

                    <h2>
                        <?php echo $totalSentences; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Speakers
                    </h6>

                    <h2>
                        <?php echo $totalSpeakers; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">
                        Domains
                    </h6>

                    <h2>
                        <?php echo $totalDomains; ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- =============================================================== -->
    <!-- Add / Edit -->
    <!-- =============================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">

            <strong>Add / Edit Sentence Pair</strong>

        </div>

        <div class="card-body">

            <form
                id="sentenceForm"
                autocomplete="off"
            >

                <div class="row">

                    <div class="col-md-2 mb-3">

                        <label class="form-label">
                            Corpus ID
                        </label>

                        <input
                            type="text"
                            id="corpus_id"
                            name="corpus_id"
                            maxlength="5"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="col-md-5 mb-3">

                        <label class="form-label">
                            Manipuri
                        </label>

                        <textarea
                            id="manipuri"
                            name="manipuri"
                            class="form-control"
                            rows="2"
                            required
                        ></textarea>

                    </div>

                    <div class="col-md-5 mb-3">

                        <label class="form-label">
                            English
                        </label>

                        <textarea
                            id="english"
                            name="english"
                            class="form-control"
                            rows="2"
                            required
                        ></textarea>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Speaker ID
                        </label>

                        <input
                            type="text"
                            id="speaker_id"
                            name="speaker_id"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Domain
                        </label>

                        <input
                            type="text"
                            id="domain"
                            name="domain"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Remarks
                        </label>

                        <input
                            type="text"
                            id="remarks"
                            name="remarks"
                            class="form-control"
                        >

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    Save
                </button>

                <button
                    type="reset"
                    class="btn btn-secondary"
                >
                    Clear
                </button>

            </form>

        </div>

    </div>

    <!-- =============================================================== -->
    <!-- Import CSV -->
    <!-- =============================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-success text-white">

            <strong>Import CSV</strong>

        </div>

        <div class="card-body">

            <form
                id="importForm"
                enctype="multipart/form-data"
            >

                <div class="input-group">

                    <input
                        type="file"
                        class="form-control"
                        name="csv_file"
                        accept=".csv"
                        required
                    >

                    <button
                        class="btn btn-success"
                        type="submit"
                    >
                        Import
                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- =============================================================== -->
    <!-- Search -->
    <!-- =============================================================== -->

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">

            <strong>Corpus Search</strong>

        </div>

        <div class="card-body">

            <input
                type="text"
                id="search"
                class="form-control mb-3"
                placeholder="Search Manipuri or English..."
            >

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                    <tr>

                        <th width="90">
                            ID
                        </th>

                        <th>
                            Manipuri
                        </th>

                        <th>
                            English
                        </th>

                        <th width="180">
                            Action
                        </th>

                    </tr>

                    </thead>

                    <tbody id="results">

                    <tr>

                        <td
                            colspan="4"
                            class="text-center text-muted"
                        >
                            Start typing to search...
                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script>

const form = document.getElementById('sentenceForm');

form.addEventListener('submit', function (e)
{
    e.preventDefault();

    fetch('../api/admin/save.php', {

        method: 'POST',

        body: new FormData(form)

    })
    .then(r => r.json())
    .then(data => {

        alert(data.message);

        if (data.success)
        {
            form.reset();
        }

    });
});

document.getElementById('importForm')
.addEventListener('submit', function(e)
{
    e.preventDefault();

    fetch('../api/admin/import.php', {

        method: 'POST',

        body: new FormData(this)

    })
    .then(r => r.json())
    .then(data => {

        alert(data.message);

    });

});

let timer = null;

document.getElementById('search')
.addEventListener('keyup', function ()
{
    clearTimeout(timer);

    const keyword = this.value;

    timer = setTimeout(function ()
    {

        fetch(
            '../api/public/search.php?q=' +
            encodeURIComponent(keyword)
        )
        .then(r => r.json())
        .then(rows =>
        {

            const tbody = document.getElementById('results');

            tbody.innerHTML = '';

            if (rows.length === 0)
            {
                tbody.innerHTML =
                    '<tr><td colspan="4" class="text-center">No records found.</td></tr>';

                return;
            }

            rows.forEach(function (row)
            {

                tbody.innerHTML +=
                    '<tr>' +

                    '<td>' +
                    row.corpus_id +
                    '</td>' +

                    '<td>' +
                    row.manipuri +
                    '</td>' +

                    '<td>' +
                    row.english +
                    '</td>' +

                    '<td>' +

                    '<button class="btn btn-sm btn-primary me-2" onclick="loadSentence(\'' +
                    row.corpus_id +
                    '\')">Edit</button>' +

                    '<button class="btn btn-sm btn-danger" onclick="deleteSentence(\'' +
                    row.corpus_id +
                    '\')">Delete</button>' +

                    '</td>' +

                    '</tr>';

            });

        });

    }, 250);

});

function loadSentence(id)
{
    fetch('../api/public/sentence.php?id=' + encodeURIComponent(id))
    .then(r => r.json())
    .then(row =>
    {
        document.getElementById('corpus_id').value = row.corpus_id;
        document.getElementById('manipuri').value = row.manipuri;
        document.getElementById('english').value = row.english;
        document.getElementById('speaker_id').value = row.speaker_id;
        document.getElementById('domain').value = row.domain;
        document.getElementById('remarks').value = row.remarks;

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

function deleteSentence(id)
{
    if (!confirm('Delete this sentence?'))
    {
        return;
    }

    const fd = new FormData();

    fd.append('corpus_id', id);

    fetch('../api/admin/delete.php', {

        method: 'POST',

        body: fd

    })
    .then(r => r.json())
    .then(data =>
    {
        alert(data.message);

        document.getElementById('search').dispatchEvent(new Event('keyup'));
    });

}

</script>

</body>

</html>