$(document).ready(function () {
    const DOC_ROOT = '_Doc/';
    const DEFAULT_DOCUMENT = '_tabel_of_content.md';
    const DocumentRoot = new URL(DOC_ROOT, window.location.href);

    let CurrentDocument = null;
    let RequestMarkdown = null;
    let CurrentContent = '';
    let CurrentMode = 'preview';

    // CSS khusus tampilan Raw Markdown
    function AddRawModeStyle() {
        if ($('#MarkdownRawStyle').length) return;

        const Style = `
            .content_md .markdown-raw {
                display: block;
                width: 100%;
                margin: 0;
                padding: 20px;
                overflow-x: auto;
                background: #e9ecef;
                color: #212529;
                border: 1px solid #ced4da;
                border-radius: 6px;
                font-family: Consolas, "Courier New", monospace;
                font-size: 13px;
                line-height: 1.8;
                white-space: pre;
                tab-size: 4;
            }

            .content_md .markdown-raw code {
                display: block;
                padding: 0;
                background: transparent;
                color: inherit;
                font-family: inherit;
                font-size: inherit;
                white-space: inherit;
            }

            .content_md .markdown-raw .raw-heading {
                color: #0056b3;
                font-weight: 700;
            }

            .content_md .markdown-raw .raw-marker {
                color: #c62828;
                font-weight: 700;
            }

            .content_md .markdown-raw .raw-link {
                color: #087443;
            }

            .content_md .markdown-raw .raw-link-text {
                color: #0056b3;
                font-weight: 600;
            }

            .content_md .markdown-raw .raw-code {
                color: #7b1fa2;
                background: #e2d5eb;
                border-radius: 3px;
            }

            .content_md .markdown-raw .raw-bold {
                color: #9c3d00;
                font-weight: 700;
            }

            .content_md .markdown-raw .raw-strike {
                color: #6c757d;
                text-decoration: line-through;
            }

            .content_md .markdown-raw .raw-table {
                color: #212529;
            }

            .content_md .markdown-raw .raw-table-separator {
                color: #c62828;
                font-weight: 700;
            }

            .content_md .markdown-raw .raw-list {
                color: #0056b3;
                font-weight: 700;
            }

            .content_md .markdown-raw .raw-quote {
                color: #087443;
                font-weight: 600;
            }

            .content_md .markdown-raw .raw-emphasis {
                color: #c62828;
            }
        `;

        $('<style>', {
            id: 'MarkdownRawStyle',
            text: Style
        }).appendTo('head');
    }

    // Mengamankan teks sebelum ditampilkan sebagai HTML
    function EscapeHTML(text) {
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Pewarnaan sintaks Markdown
    function HighlightInlineMarkdown(text) {
        const Pattern = /(\[[^\]]+\]\([^)]+\)|`[^`]*`|\*\*.*?\*\*|__.*?__|~~.*?~~|\|)/g;

        return text.split(Pattern).map(function (Part) {
            if (!Part) return '';

            // Link Markdown
            const LinkMatch = Part.match(/^\[([^\]]+)\]\(([^)]+)\)$/);

            if (LinkMatch) {
                return '<span class="raw-marker">[</span>' +
                    '<span class="raw-link-text">' + EscapeHTML(LinkMatch[1]) + '</span>' +
                    '<span class="raw-marker">](</span>' +
                    '<span class="raw-link">' + EscapeHTML(LinkMatch[2]) + '</span>' +
                    '<span class="raw-marker">)</span>';
            }

            // Inline Code
            if (/^`[^`]*`$/.test(Part)) {
                return '<span class="raw-code">' +
                    '<span class="raw-marker">`</span>' +
                    EscapeHTML(Part.slice(1, -1)) +
                    '<span class="raw-marker">`</span>' +
                    '</span>';
            }

            // Bold
            if (/^(\*\*|__).*\1$/.test(Part)) {
                const Marker = Part.substring(0, 2);

                return '<span class="raw-marker">' + Marker + '</span>' +
                    '<span class="raw-bold">' + EscapeHTML(Part.slice(2, -2)) + '</span>' +
                    '<span class="raw-marker">' + Marker + '</span>';
            }

            // Strikethrough
            if (/^~~.*~~$/.test(Part)) {
                return '<span class="raw-marker">~~</span>' +
                    '<span class="raw-strike">' + EscapeHTML(Part.slice(2, -2)) + '</span>' +
                    '<span class="raw-marker">~~</span>';
            }

            // Pemisah kolom tabel
            if (Part === '|') {
                return '<span class="raw-marker">|</span>';
            }

            return EscapeHTML(Part);
        }).join('');
    }

    // Pewarnaan seluruh dokumen Markdown
    function HighlightMarkdownRaw(content) {
        return content.split('\n').map(function (Line) {
            const HeadingMatch = Line.match(/^(\s*)(#{1,6})(\s+)(.*)$/);

            // Heading
            if (HeadingMatch) {
                return EscapeHTML(HeadingMatch[1]) +
                    '<span class="raw-marker">' + EscapeHTML(HeadingMatch[2]) + '</span>' +
                    EscapeHTML(HeadingMatch[3]) +
                    '<span class="raw-heading">' +
                    HighlightInlineMarkdown(HeadingMatch[4]) +
                    '</span>';
            }

            // Pemisah tabel Markdown
            if (/^\s*\|?[\s:|-]+\|?\s*$/.test(Line) && Line.includes('-')) {
                return '<span class="raw-table-separator">' +
                    EscapeHTML(Line) +
                    '</span>';
            }

            // Baris tabel Markdown
            if (Line.trim().startsWith('|') && Line.includes('|')) {
                return '<span class="raw-table">' +
                    HighlightInlineMarkdown(Line) +
                    '</span>';
            }

            // Daftar bernomor dan bullet
            const ListMatch = Line.match(/^(\s*)([-*+]|\d+\.)\s+(.*)$/);

            if (ListMatch) {
                return EscapeHTML(ListMatch[1]) +
                    '<span class="raw-list">' + EscapeHTML(ListMatch[2]) + '</span> ' +
                    HighlightInlineMarkdown(ListMatch[3]);
            }

            // Blockquote
            const QuoteMatch = Line.match(/^(\s*&gt;|\s*>)(.*)$/);

            if (QuoteMatch) {
                return '<span class="raw-quote">' +
                    EscapeHTML(QuoteMatch[1]) +
                    HighlightInlineMarkdown(QuoteMatch[2]) +
                    '</span>';
            }

            return HighlightInlineMarkdown(Line);
        }).join('\n');
    }

    function ResolveDocumentURL(file, baseURL = DocumentRoot) {
        try {
            const DocumentURL = new URL(file, baseURL);

            if (
                DocumentURL.origin !== window.location.origin ||
                !DocumentURL.pathname.startsWith(DocumentRoot.pathname) ||
                !DocumentURL.pathname.toLowerCase().endsWith('.md')
            ) return null;

            DocumentURL.hash = '';
            return DocumentURL;
        } catch {
            return null;
        }
    }

    function GetRelativePath(DocumentURL) {
        return decodeURIComponent(
            DocumentURL.pathname.substring(DocumentRoot.pathname.length)
        );
    }

    function UpdateDocumentInfo(DocumentURL, xhr) {
        $('#PathOfDocument').text(DOC_ROOT + GetRelativePath(DocumentURL));

        const LastModified = xhr.getResponseHeader('Last-Modified');
        const UpdateDate = LastModified ? new Date(LastModified) : null;

        $('#LastUpdate').text(
            !UpdateDate || isNaN(UpdateDate.getTime())
                ? 'Tidak tersedia'
                : UpdateDate.toLocaleString('id-ID')
        );
    }

    function UpdateBackButton() {
        const IsTOC = CurrentDocument &&
            GetRelativePath(CurrentDocument) === DEFAULT_DOCUMENT;

        $('#BtnBackTOC').toggle(!IsTOC);
    }

    function UpdateHistory(DocumentURL, historyAction) {
        if (historyAction === 'none') return;

        const RelativePath = GetRelativePath(DocumentURL);
        const HistoryURL = new URL(window.location.href);

        HistoryURL.searchParams.set('doc', RelativePath);

        if (historyAction === 'replace') {
            window.history.replaceState(
                { document: RelativePath },
                '',
                HistoryURL.href
            );
        } else {
            window.history.pushState(
                { document: RelativePath },
                '',
                HistoryURL.href
            );
        }
    }

    function LoadMarkdown(file, historyAction = 'push', baseURL = DocumentRoot) {
        const DocumentURL = ResolveDocumentURL(file, baseURL);

        if (!DocumentURL) {
            showToast('error', 'Lokasi dokumen tidak valid.');
            return;
        }

        if (RequestMarkdown) {
            RequestMarkdown.abort();
            RequestMarkdown = null;
        }

        $('.content_md').html(`
            <div class="text-center py-5">
                <div class="spinner-border spinner-border-sm text-primary"></div>
                <div class="mt-2 text-muted">Memuat dokumentasi...</div>
            </div>
        `);

        $('#PathOfDocument').text('Memuat...');
        $('#LastUpdate').text('-');

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
                UpdateBackButton();
            },

            error: function (xhr, status) {
                if (RequestMarkdown !== Request || status === 'abort') return;

                let Message = 'Gagal memuat dokumentasi.';

                if (xhr.status === 404) {
                    Message = 'Dokumen tidak ditemukan.';
                } else if (xhr.status === 403) {
                    Message = 'Akses ke dokumen ditolak.';
                } else if (xhr.status === 0) {
                    Message = 'Tidak dapat menghubungi server.';
                }

                $('.content_md').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> ${Message}
                    </div>
                `);

                $('#LastUpdate').text('-');
                showToast('error', Message);
            },

            complete: function () {
                if (RequestMarkdown === Request) {
                    RequestMarkdown = null;
                }
            }
        });

        RequestMarkdown = Request;
    }

    function RenderMarkdown() {
        const Container = $('.content_md');

        if (CurrentMode === 'raw') {
            const RawContent = HighlightMarkdownRaw(CurrentContent);

            const Pre = $('<pre>', {
                class: 'markdown-raw'
            });

            const Code = $('<code>', {
                class: 'language-markdown'
            }).html(RawContent);

            Pre.append(Code);
            Container.empty().append(Pre);

            return;
        }

        if (typeof marked === 'undefined' || typeof marked.parse !== 'function') {
            Container.html(`
                <div class="alert alert-danger">
                    Library Marked.js tidak ditemukan.
                </div>
            `);
            return;
        }

        try {
            const HTMLContent = marked.parse(CurrentContent);

            Container.html(`
                <div class="markdown-document">
                    ${HTMLContent}
                </div>
            `);

            Container.find('table tbody tr td:last-child a')
                .addClass('btn btn-outline-primary btn-sm');

        } catch (error) {
            Container.html(`
                <div class="alert alert-danger">
                    Gagal menampilkan dokumentasi Markdown.
                </div>
            `);

            console.error('Markdown Render Error:', error);
        }
    }

    function ChangeMode(mode) {
        if (!['preview', 'raw'].includes(mode)) return;

        CurrentMode = mode;
        RenderMarkdown();

        $('#ModePreview').toggleClass('active', mode === 'preview');
        $('#ModeRaw').toggleClass('active', mode === 'raw');
    }

    // Navigasi link internal Markdown
    $(document).on('click', '.content_md a', function (e) {
        if (CurrentMode !== 'preview') return;

        const Href = $(this).attr('href');
        if (!Href) return;

        if (
            $(this).attr('target') === '_blank' ||
            e.ctrlKey || e.metaKey || e.shiftKey || e.altKey ||
            e.which === 2
        ) return;

        let TargetURL;

        try {
            TargetURL = new URL(Href, CurrentDocument);
        } catch {
            return;
        }

        if (
            TargetURL.origin !== window.location.origin ||
            !TargetURL.pathname.startsWith(DocumentRoot.pathname) ||
            !TargetURL.pathname.toLowerCase().endsWith('.md')
        ) return;

        e.preventDefault();
        LoadMarkdown(TargetURL.href, 'push');
    });

    // Tombol Preview
    $(document).on('click', '#ModePreview', function () {
        ChangeMode('preview');
    });

    // Tombol Raw
    $(document).on('click', '#ModeRaw', function () {
        ChangeMode('raw');
    });

    // Tombol kembali ke Table of Contents
    $(document).on('click', '#BtnBackTOC', function () {
        LoadMarkdown(DEFAULT_DOCUMENT, 'push', DocumentRoot);
    });

    // Browser Back / Forward
    $(window).on('popstate', function (e) {
        const State = e.originalEvent.state;
        const URLDocument = new URLSearchParams(window.location.search).get('doc');

        const TargetDocument =
            (State && State.document) ||
            URLDocument ||
            DEFAULT_DOCUMENT;

        LoadMarkdown(TargetDocument, 'none', DocumentRoot);
    });

    // Inisialisasi
    AddRawModeStyle();

    let InitialDocument = new URLSearchParams(window.location.search).get('doc');

    if (InitialDocument && InitialDocument.startsWith(DOC_ROOT)) {
        InitialDocument = InitialDocument.substring(DOC_ROOT.length);
    }

    LoadMarkdown(
        InitialDocument || DEFAULT_DOCUMENT,
        'replace',
        DocumentRoot
    );
});