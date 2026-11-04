/* ------------------------------------------------------------------
   게시판 목록 공통 스크립트  (Gallery / Publication / Members / Alumni)

   원래 사이트(그누보드)는 서버가 목록을 잘라서 페이지를 만들고,
   연도 분류와 검색도 서버가 처리했습니다.
   지금 사이트는 서버가 없는 HTML 파일이라, 같은 일을 브라우저에서 합니다.

   - 주소 형식은 원본과 동일하게 유지합니다
       ?page=2            페이지 넘김
       ?sca=2025          연도 분류 (Publication)
       ?sfl=...&stx=...   검색
   - 이 스크립트가 실행되지 않아도 글이 사라지지는 않습니다
     (전부 보이기만 하고 페이지 나눔이 없어집니다)
------------------------------------------------------------------ */
(function () {
    'use strict';

    var PER_PAGE = 15;      // 한 페이지에 보여줄 글 수 (원본과 동일)
    var NEW_DAYS = 7;       // 며칠 이내 글에 N 표시를 붙일지

    function qs(s, r) { return (r || document).querySelector(s); }
    function qsa(s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); }
    function txt(el) { return el ? (el.textContent || '').replace(/\s+/g, ' ').trim() : ''; }

    /* ---------- 1. 어떤 목록인지 판별 ---------- */
    var kind = null, items = [], listEl = null;

    if (qs('.publiCon')) {
        listEl = qs('.publiCon');
        items = qsa('.publiCon > li').filter(function (li) { return li.querySelector('.postNum'); });
        kind = 'publication';
    } else if (qs('li.gall_li')) {
        items = qsa('li.gall_li');
        listEl = items.length ? items[0].parentNode : null;
        kind = qs('.gall_date') ? 'gallery' : 'member';
    } else if (qs('.memberWrap')) {
        listEl = qs('.memberWrap');
        items = qsa('.memberWrap > li.list');
        kind = 'member';
    }
    if (!kind || !items.length || !listEl) { return; }

    /* ---------- 2. 각 글의 정보를 미리 뽑아둔다 ---------- */
    var records = items.map(function (el) {
        var r = { el: el, year: null, date: null, title: '', body: '', author: '', journal: '', when: '' };

        if (kind === 'gallery') {
            r.title = txt(qs('.bo_tit', el)).replace(/\s*N\s*새글\s*/, '');
            r.body = txt(qs('.txt', el));
            var d = txt(qs('.gall_date', el)).replace(/^작성일\s*/, '');
            var m = d.match(/(\d{4})-(\d{2})-(\d{2})/);
            if (m) { r.date = new Date(+m[1], +m[2] - 1, +m[3]); r.year = m[1]; }
        } else if (kind === 'publication') {
            r.title = txt(qs('.txtTitle', el));
            r.author = txt(qs('.txtAuthor', el));
            r.journal = txt(qs('.txtJournal', el));
            r.when = txt(qs('.txtPage', el));
            r.body = r.title + ' ' + r.author + ' ' + r.journal + ' ' + r.when;
        } else {
            r.title = txt(qs('.name, .eng, h1', el));
            r.body = txt(el);
        }
        return r;
    });

    /* 연도 분류(Publication) — 바로 위에 있는 연도 머리글에서 가져온다 */
    if (kind === 'publication') {
        var curYear = null;
        qsa('.publiCon > li').forEach(function (li) {
            if (li.classList.contains('cate_year')) {
                curYear = txt(qs('.cateName', li));
                li.setAttribute('data-year', curYear || '');
                return;
            }
            var rec = records.filter(function (x) { return x.el === li; })[0];
            if (rec) { rec.year = curYear; li.setAttribute('data-year', curYear || ''); }
        });
    }

    /* ---------- 3. 주소에서 현재 상태 읽기 ---------- */
    function param(name) {
        var m = new RegExp('[?&]' + name + '=([^&]*)').exec(location.search);
        return m ? decodeURIComponent(m[1].replace(/\+/g, ' ')) : '';
    }
    var state = {
        page: Math.max(1, parseInt(param('page'), 10) || 1),
        sca: param('sca'),
        sfl: param('sfl'),
        stx: param('stx')
    };

    /* ---------- 4. 조건에 맞는 글 고르기 ---------- */
    function matchSearch(r) {
        if (!state.stx) { return true; }
        var needle = state.stx.toLowerCase();
        var hay;
        switch (state.sfl) {
            case 'wr_subject': hay = r.title; break;
            case 'wr_content': hay = r.body; break;
            case 'wr_1': hay = r.author; break;
            case 'wr_3': hay = r.journal; break;
            case 'wr_7': hay = r.when; break;
            default: hay = r.title + ' ' + r.body + ' ' + r.author + ' ' + r.journal + ' ' + r.when;
        }
        return (hay || '').toLowerCase().indexOf(needle) !== -1;
    }
    function selected() {
        return records.filter(function (r) {
            if (state.sca && r.year !== state.sca) { return false; }
            return matchSearch(r);
        });
    }

    /* ---------- 5. 자리 만들기 (상단 Total / 하단 페이지번호) ---------- */
    function ensureTop() {
        var top = qs('#bo_btn_top');
        if (top) { return top; }
        top = document.createElement('div');
        top.id = 'bo_btn_top';
        var totalBox = document.createElement('div');
        totalBox.id = 'bo_list_total';
        top.appendChild(totalBox);

        // 갤러리에만 검색 버튼이 있다 (원본과 동일)
        if (kind === 'gallery' && qs('.bo_sch_wrap')) {
            var ul = document.createElement('ul');
            ul.className = 'btn_bo_user';
            ul.innerHTML = '<li><button type="button" class="btn_bo_sch btn_b01 btn" title="게시판 검색">' +
                '<i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">게시판 검색</span></button></li>';
            top.appendChild(ul);
        }
        var anchor = qs('.publi_list') || listEl;
        anchor.parentNode.insertBefore(top, anchor);
        return top;
    }
    function ensurePg() {
        var nav = qs('nav.pg_wrap.js-pg');
        if (nav) { return nav; }
        nav = document.createElement('nav');
        nav.className = 'pg_wrap js-pg';
        var after = qs('.publi_list') || listEl;
        after.parentNode.insertBefore(nav, after.nextSibling);
        return nav;
    }

    /* ---------- 6. 화면 그리기 ---------- */
    function buildUrl(over) {
        var p = {
            sca: ('sca' in over) ? over.sca : state.sca,
            sfl: ('sfl' in over) ? over.sfl : state.sfl,
            stx: ('stx' in over) ? over.stx : state.stx,
            page: ('page' in over) ? over.page : state.page
        };
        var q = [];
        if (p.sca) { q.push('sca=' + encodeURIComponent(p.sca)); }
        if (p.stx) { q.push('sfl=' + encodeURIComponent(p.sfl || 'wr_subject') + '&stx=' + encodeURIComponent(p.stx)); }
        if (p.page && p.page > 1) { q.push('page=' + p.page); }
        var base = location.pathname.split('/').pop() || 'index.html';
        return base + (q.length ? ('?' + q.join('&')) : '');
    }

    /* 글 하나를 보이게/안 보이게 한다.
       원래 display 값을 기억해 뒀다가 되돌려 놓는다. */
    function setShown(el, on) {
        if (on) {
            el.hidden = false;
            el.style.display = el.getAttribute('data-disp') || '';
        } else {
            if (!el.hasAttribute('data-disp')) {
                el.setAttribute('data-disp', el.style.display || '');
            }
            el.hidden = true;
            el.style.display = 'none';
        }
    }

    function render() {
        var list = selected();
        var totalPages = Math.max(1, Math.ceil(list.length / PER_PAGE));
        if (state.page > totalPages) { state.page = totalPages; }
        var from = (state.page - 1) * PER_PAGE;
        var show = list.slice(from, from + PER_PAGE);

        // 글 보이기/숨기기
        // 주의: hidden 속성만 쓰면 안 된다.
        //   스킨 CSS 에 .publiCon li {display:flex} 같은 규칙이 있어서
        //   브라우저 기본값([hidden]{display:none})을 덮어써 버린다.
        //   그래서 인라인 style 로 직접 끈다.
        records.forEach(function (r) { setShown(r.el, show.indexOf(r) !== -1); });

        // 갤러리는 4개마다 줄을 바꿔야 한다(box_clear).
        // 페이지를 나누면 보이는 것만 기준으로 다시 계산해야 줄이 어긋나지 않는다.
        if (kind === 'gallery' || kind === 'member') {
            records.forEach(function (r) { r.el.classList.remove('box_clear'); });
            show.forEach(function (r, i) {
                if (i > 0 && i % 4 === 0) { r.el.classList.add('box_clear'); }
            });
        }
        // 연도 머리글은 그 연도 글이 보일 때만
        qsa('.publiCon > li.cate_year').forEach(function (li) {
            var y = li.getAttribute('data-year');
            setShown(li, show.some(function (r) { return r.year === y; }));
        });

        // 글 번호 다시 매기기
        // 원본은 연도를 고르거나 검색하면 그 결과 안에서 번호를 새로 매긴다.
        //   예) 전체 31건 -> 31…1,  2025년 2건 -> 2, 1
        list.forEach(function (r, i) {
            var n = list.length - i;
            var box = qs('.postNum span', r.el) || qs('.gall_chk .sound_only', r.el);
            if (box) { box.textContent = ' ' + n; }
        });

        // Total 표기
        var totalBox = qs('#bo_list_total', ensureTop());
        if (totalBox) {
            totalBox.innerHTML = '<span>Total ' + list.length + '건</span> ' + state.page + ' 페이지';
        }

        // 페이지 번호
        var nav = ensurePg();
        if (totalPages <= 1) {
            nav.innerHTML = '';
        } else {
            var h = '<span class="pg">';
            if (state.page > 1) {
                h += '<a href="' + buildUrl({ page: 1 }) + '" class="pg_page pg_start">처음</a> ';
            }
            for (var i = 1; i <= totalPages; i++) {
                if (i === state.page) {
                    h += '<span class="sound_only">열린</span><strong class="pg_current">' + i + '</strong><span class="sound_only">페이지</span> ';
                } else {
                    h += '<a href="' + buildUrl({ page: i }) + '" class="pg_page">' + i + '<span class="sound_only">페이지</span></a> ';
                }
            }
            if (state.page < totalPages) {
                h += '<a href="' + buildUrl({ page: totalPages }) + '" class="pg_page pg_end">맨끝</a> ';
            }
            h += '</span>';
            nav.innerHTML = h;
        }

        // 연도 탭 활성 표시
        qsa('#bo_cate_ul a').forEach(function (a) {
            var label = txt(a);
            var on = state.sca ? (label === state.sca) : (label === '전체');
            if (on) { a.id = 'bo_cate_on'; } else if (a.id === 'bo_cate_on') { a.removeAttribute('id'); }
        });

        // 검색창에 현재 검색어 채워두기
        var stxInput = qs('#stx');
        if (stxInput && state.stx) { stxInput.value = state.stx; }
        var sflSel = qs('#sfl');
        if (sflSel && state.sfl) { sflSel.value = state.sfl; }
    }

    function go(over) {
        Object.keys(over).forEach(function (k) { state[k] = over[k]; });
        if (!('page' in over)) { state.page = 1; }
        try { history.pushState(null, '', buildUrl({})); } catch (err) { /* file:// 에서는 막힌다 */ }
        render();
        var top = qs('#bo_btn_top');
        if (top) { top.scrollIntoView({ block: 'start' }); }
    }

    /* ---------- 7. 클릭/검색 가로채기 ---------- */
    document.addEventListener('click', function (e) {
        var t = e.target;
        if (!t || !t.closest) { return; }

        var pg = t.closest('nav.pg_wrap.js-pg a');
        if (pg) {
            e.preventDefault();
            var m = /[?&]page=(\d+)/.exec(pg.getAttribute('href'));
            go({ page: m ? parseInt(m[1], 10) : 1 });
            return;
        }
        var cate = t.closest('#bo_cate_ul a');
        if (cate) {
            e.preventDefault();
            var label = txt(cate);
            go({ sca: (label === '전체') ? '' : label, page: 1 });
            return;
        }
        var schBtn = t.closest('.sch_btn');
        if (schBtn) {
            e.preventDefault();
            doSearch();
            return;
        }
        // 검색창 열기 — 버튼을 이 스크립트가 만들기 때문에
        // 페이지에 원래 있던 jQuery 핸들러가 붙지 않는다. 여기서 직접 연다.
        var openBtn = t.closest('.btn_bo_sch');
        if (openBtn) {
            e.preventDefault();
            var w = qs('.bo_sch_wrap');
            if (w) {
                w.style.display = (w.style.display === 'block') ? 'none' : 'block';
                var box = qs('#stx');
                if (box && w.style.display === 'block') { box.focus(); }
            }
            return;
        }
        // 닫기 버튼 / 바깥 어두운 영역
        if (t.closest('.bo_sch_cls') || t.classList.contains('bo_sch_bg')) {
            var w2 = qs('.bo_sch_wrap');
            if (w2) { w2.style.display = 'none'; }
        }
    });

    function doSearch() {
        var stxInput = qs('#stx');
        var sflSel = qs('#sfl');
        go({ stx: stxInput ? stxInput.value.trim() : '', sfl: sflSel ? sflSel.value : '', page: 1 });
        var wrap = qs('.bo_sch_wrap');
        if (wrap && wrap.style) { wrap.style.display = 'none'; }
    }

    var stx = qs('#stx');
    if (stx) {
        stx.removeAttribute('required');
        stx.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); doSearch(); }
        });
    }
    qsa('form').forEach(function (f) {
        if (f.querySelector('#stx')) {
            f.addEventListener('submit', function (e) { e.preventDefault(); doSearch(); });
        }
    });
    window.addEventListener('popstate', function () {
        state.page = Math.max(1, parseInt(param('page'), 10) || 1);
        state.sca = param('sca'); state.sfl = param('sfl'); state.stx = param('stx');
        render();
    });

    /* ---------- 8. 최근 글에 N 표시 ---------- */
    if (kind === 'gallery') {
        var today = new Date(); today.setHours(0, 0, 0, 0);
        records.forEach(function (r) {
            if (!r.date) { return; }
            var days = (today - r.date) / 86400000;
            if (days < 0 || days > NEW_DAYS) { return; }
            var tit = qs('.bo_tit', r.el);
            var p = tit ? qs('.txt', tit) : null;
            if (!tit || qs('.new_icon', tit)) { return; }
            var span = document.createElement('span');
            span.className = 'new_icon';
            span.innerHTML = 'N<span class="sound_only">새글</span>';
            if (p) { tit.insertBefore(span, p); } else { tit.appendChild(span); }
        });
    }

    render();
})();
