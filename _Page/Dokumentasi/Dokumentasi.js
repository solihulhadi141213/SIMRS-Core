$(document).ready(function () {
    // Konstanta direktori dokumen dan file default
    const DOC_ROOT = '_Doc/';
    const DEFAULT_DOCUMENT = '_tabel_of_content.md';
    const DocumentRoot = new URL(DOC_ROOT, window.location.href);

    // State / variabel global aplikasi
    let CurrentDocument = null, RequestMarkdown = null, CurrentContent = '', CurrentMode = 'raw';

    // Memvalidasi dan membuat URL dokumen target berdasarkan direktori root
    function ResolveDocumentURL(file, baseURL = DocumentRoot) {
        try {
            const DocumentURL = new URL(file, baseURL);
            if (DocumentURL.origin !== window.location.origin || !DocumentURL.pathname.startsWith(DocumentRoot.pathname) || !DocumentURL.pathname.toLowerCase().endsWith('.md')) {
                return null;
            }
            DocumentURL.hash = ''; // Bersihkan fragment URL
            return DocumentURL;
        } catch {
            return null;
        }
    }

    // Mengambil path relatif dokumen terhadap direktori root
    function GetRelativePath(DocumentURL) {
        return decodeURIComponent(DocumentURL.pathname.substring(DocumentRoot.pathname.length));
    }

    // Memperbarui informasi path file dan tanggal pembaruan terakhir pada UI
    function UpdateDocumentInfo(DocumentURL, xhr) {
        $('#PathOfDocument').text(DOC_ROOT + GetRelativePath(DocumentURL));
        const LastModified = xhr.getResponseHeader('Last-Modified');
        const UpdateDate = LastModified ? new Date(LastModified) : null;
        $('#LastUpdate').text(!UpdateDate || isNaN(UpdateDate.getTime()) ? 'Tidak tersedia' : UpdateDate.toLocaleString('id-ID'));
    }

    // Memperbarui riwayat state pada URL browser (pushState / replaceState)
    function UpdateHistory(DocumentURL, historyAction) {
        if (historyAction === 'none') return;
        const RelativePath = GetRelativePath(DocumentURL);
        const HistoryURL = new URL(window.location.href);
        HistoryURL.searchParams.set('doc', RelativePath);
        
        if (historyAction === 'replace') {
            window.history.replaceState({ document: RelativePath }, '', HistoryURL.href);
        } else {
            window.history.pushState({ document: RelativePath }, '', HistoryURL.href);
        }
    }

    // Mengambil dan memuat konten file Markdown melalui request AJAX
    function LoadMarkdown(file, historyAction = 'push', baseURL = DocumentRoot) {
        const DocumentURL = ResolveDocumentURL(file, baseURL);
        if (!DocumentURL) {
            showToast('error', 'Lokasi dokumen tidak valid.');
            return;
        }

        // Batalkan request AJAX sebelumnya jika masih aktif
        if (RequestMarkdown) {
            RequestMarkdown.abort();
            RequestMarkdown = null;
        }

        // Tampilkan indikator loading pada container dokumen
        $('.content_md').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary"></div>
                <div class="mt-2 text-muted">Memuat dokumentasi...</div>
            </div>
        `);
        $('#PathOfDocument').text('Memuat...');
        $('#LastUpdate').text('-');

        // Eksekusi AJAX request baru
        const Request = $.ajax({
            url: DocumentURL.href,
            type: 'GET',
            dataType: 'text',
            cache: false,
            success: function (response, status, xhr) {
                if (RequestMarkdown !== Request) return;
                CurrentContent = response;
                CurrentDocument = DocumentURL;
                RenderMarkdown();
                UpdateDocumentInfo(DocumentURL, xhr);
                UpdateHistory(DocumentURL, historyAction);
            },
            error: function (xhr, status) {
                if (RequestMarkdown !== Request || status === 'abort') return;
                
                let Message = 'Gagal memuat dokumentasi.';
                if (xhr.status === 404) Message = 'Dokumen tidak ditemukan.';
                else if (xhr.status === 403) Message = 'Akses ke dokumen ditolak.';
                else if (xhr.status === 0) Message = 'Tidak dapat menghubungi server.';

                $('.content_md').html(`<div class="alert alert-danger"><i class="bi bi-exclamation-triangle"></i> ${Message}</div>`);
                $('#LastUpdate').text('-');
                showToast('error', Message);
            },
            complete: function () {
                if (RequestMarkdown === Request) RequestMarkdown = null;
            }
        });

        RequestMarkdown = Request;
    }

    // Merender konten dokumen berdasarkan mode aktif ('raw' atau 'preview')
    function RenderMarkdown() {
        if (CurrentMode === 'raw') {
            $('.content_md').empty().append($('<pre>').append($('<code>').text(CurrentContent)));
            return;
        }

        if (typeof marked === 'undefined' || typeof marked.parse !== 'function') {
            $('.content_md').html(`<div class="alert alert-danger">Library Marked.js tidak ditemukan.</div>`);
            return;
        }

        try {
            $('.content_md').html(marked.parse(CurrentContent));
        } catch (error) {
            $('.content_md').html(`<div class="alert alert-danger">Gagal menampilkan dokumentasi Markdown.</div>`);
            console.error('Markdown Render Error:', error);
        }
    }

    // Mengubah mode tampilan antara 'preview' dan 'raw' serta memperbarui status tombol UI
    function ChangeMode(mode) {
        if (!['preview', 'raw'].includes(mode)) return;
        CurrentMode = mode;
        RenderMarkdown();
        $('#ModePreview').toggleClass('active', mode === 'preview');
        $('#ModeRaw').toggleClass('active', mode === 'raw');
    }

    // Event Handler: Navigasi klik tautan internal pada dokumen Markdown
    $(document).on('click', '.content_md a', function (e) {
        if (CurrentMode !== 'preview') return;
        const Href = $(this).attr('href');
        if (!Href) return;

        // Abaikan jika dibuka di tab baru atau menggunakan tombol modifier keyboard/mouse
        if ($(this).attr('target') === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey || e.which === 2) return;

        let TargetURL;
        try {
            TargetURL = new URL(Href, CurrentDocument);
        } catch {
            return;
        }

        if (TargetURL.origin !== window.location.origin || !TargetURL.pathname.startsWith(DocumentRoot.pathname) || !TargetURL.pathname.toLowerCase().endsWith('.md')) {
            return;
        }

        e.preventDefault();
        LoadMarkdown(TargetURL.href, 'push');
    });

    // Event Handler: Tombol pemilihan mode tampilan
    $(document).on('click', '#ModePreview', () => ChangeMode('preview'));
    $(document).on('click', '#ModeRaw', () => ChangeMode('raw'));

    // Event Handler: Navigasi tombol Back / Forward pada browser (popstate)
    $(window).on('popstate', function (e) {
        const State = e.originalEvent.state;
        const URLDocument = new URLSearchParams(window.location.search).get('doc');
        const TargetDocument = (State && State.document) || URLDocument || DEFAULT_DOCUMENT;
        LoadMarkdown(TargetDocument, 'none', DocumentRoot);
    });

    // Inisialisasi awal dokumen saat halaman pertama kali dimuat
    let InitialDocument = new URLSearchParams(window.location.search).get('doc');
    if (InitialDocument && InitialDocument.startsWith(DOC_ROOT)) {
        InitialDocument = InitialDocument.substring(DOC_ROOT.length);
    }

    LoadMarkdown(InitialDocument || DEFAULT_DOCUMENT, 'replace', DocumentRoot);
});