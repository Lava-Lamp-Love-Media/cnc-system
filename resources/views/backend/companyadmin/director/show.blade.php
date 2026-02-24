@extends('layouts.app')

@section('title', 'Shop Director')
@section('page-title', 'Shop Director')

@section('style')
<style>
/* ══════════════════════════════════════════════
   DIRECTOR PAGE — full-screen override
   Hides AdminLTE sidebar, top menubar, header, footer
   so the 4-column layout fills the entire viewport.
══════════════════════════════════════════════ */

/* Hide sidebar completely */
body.director-page .main-sidebar,
body.director-page .main-sidebar * { display: none !important; }

/* Hide top menubar */
body.director-page .top-menubar { display: none !important; }

/* Hide default AdminLTE main header (already hidden globally, but just in case) */
body.director-page .main-header  { display: none !important; }

/* Hide breadcrumb header and footer */
body.director-page .content-header { display: none !important; }
body.director-page .main-footer    { display: none !important; }

/* Reset content-wrapper — no sidebar margin, fill full viewport */
body.director-page .content-wrapper {
    padding: 0 !important;
    margin-left: 0 !important;
    margin-top: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    background: #d0daea;
}

/* Also kill the container-fluid padding from section.content */
body.director-page section.content { padding: 0 !important; }
body.director-page .container-fluid { padding: 0 !important; max-width: 100% !important; }

/* Transition override — sidebar push animation */
body.director-page.sidebar-mini .content-wrapper { margin-left: 0 !important; }

/* ── Director sub-header bar ── */
/* ── Director top bar — matches app.blade.php top-menubar style ── */
.dir-topbar {
    background: #4a5f7f;
    border-bottom: 2px solid rgba(0,0,0,.15);
    height: 50px;
    display: flex;
    align-items: center;
    padding: 0 10px;
    gap: 6px;
    flex-shrink: 0;
    box-shadow: 0 2px 4px rgba(0,0,0,.12);
}
.dir-topbar .dt-title {
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    flex: 1;
    text-align: center;
    letter-spacing: .2px;
}
/* Back link styled as nav-link */
.dir-topbar .dt-back {
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 0 12px;
    height: 50px;
    display: flex;
    align-items: center;
    gap: 5px;
    border-right: 1px solid rgba(255,255,255,.12);
    text-decoration: none;
    transition: background .15s;
    white-space: nowrap;
}
.dir-topbar .dt-back:hover { background: rgba(255,255,255,.15); color: #fff; text-decoration: none; }

.dtbtn {
    padding: 5px 14px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    border: 1px solid rgba(255,255,255,.25);
    cursor: pointer;
    background: rgba(255,255,255,.12);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    transition: background .1s;
    white-space: nowrap;
}
.dtbtn:hover   { background: rgba(255,255,255,.22); }
.dtbtn.green   { background: #16a34a; border-color: #15803d; }
.dtbtn.green:hover { background: #15803d; }
.dtbtn.blue    { background: #3a70c8; border-color: #2a5aaa; }
.dtbtn.blue:hover  { background: #2a5aaa; }
.dtbtn.amber   { background: #d97706; border-color: #b45309; }
.dtbtn.amber:hover { background: #b45309; }

/* ── 4-column shell ── */
.dir-shell {
    display: flex;
    flex: 1;
    overflow: hidden;
    font-family: 'DM Sans', sans-serif;
}

/* ══ COL 1 — PALETTE ══ */
.dir-pal {
    width: 210px;
    flex-shrink: 0;
    background: #d0daea;
    border-right: 2px solid #a8b8cc;
    overflow-y: auto;
    padding: 5px 4px;
}
.dir-pal::-webkit-scrollbar { width: 4px; }
.dir-pal::-webkit-scrollbar-thumb { background: #a0b0c4; border-radius: 2px; }

.dp-sec { background: #b0c0d4; border: 1px solid #90a4b8; border-radius: 3px; padding: 3px 0; font-size: 11px; font-weight: 800; color: #1a2540; text-align: center; margin-bottom: 4px; letter-spacing: .5px; }
/* Shape legend tooltip on palette nodes */
.dpn[data-shape]::after {
    content: attr(data-shapelabel);
    position: absolute;
    bottom: -18px; left: 50%;
    transform: translateX(-50%);
    background: #1a2540;
    color: #fff;
    font-size: 8px;
    padding: 1px 5px;
    border-radius: 3px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity .15s;
    z-index: 10;
}
.dpn[data-shape]:hover::after { opacity: 1; }
.dp-cg  { display: grid; grid-template-columns: 1fr 1fr; gap: 3px; margin-bottom: 3px; }
.dp-cb  { padding: 4px 4px; border-radius: 4px; font-size: 10px; font-weight: 700; border: 1px solid #90a4b8; background: #c0d0e0; color: #1a2540; cursor: pointer; text-align: center; font-family: 'DM Sans', sans-serif; transition: background .1s; }
.dp-cb:hover     { background: #a8bcd0; }
.dp-cb.dg        { background: #58aa72; color: #fff; border-color: #469a60; }
.dp-cb.full      { grid-column: 1/-1; background: #58aa72; color: #fff; border-color: #469a60; }
.dp-divider      { height: 1px; background: #90a4b8; margin: 5px 2px; }

/* ── Palette base node (col 1) ── */
.dpn {
    display: flex; align-items: center; gap: 5px;
    padding: 6px 12px;
    border-radius: 18px;          /* default pill — overridden by shape classes */
    font-size: 11px; font-weight: 700;
    cursor: grab; border: 2px solid rgba(0,0,0,.2);
    box-shadow: 0 2px 5px rgba(0,0,0,.22);
    margin-bottom: 4px; user-select: none;
    transition: filter .12s, transform .12s;
    position: relative;
}
.dpn:hover  { filter: brightness(.88); transform: translateX(3px); }
.dpn:active { cursor: grabbing; opacity:.8; }
.dpn i      { font-size: 10px; opacity: .85; pointer-events:none; }
.dpn-row    { display: flex; gap: 4px; margin-bottom: 4px; }
.dpn-row .dpn { flex: 1; margin-bottom: 0; padding: 5px 6px; justify-content: center; }

/* ════════ PALETTE SHAPE CLASSES ════════
   6 distinct shapes so col1 visually previews how item looks in the lane
═══════════════════════════════════════ */

/* ARROW — Operation/Process group */
.dpn.shape-arrow {
    border-radius: 0;
    clip-path: polygon(0% 0%, calc(100% - 14px) 0%, 100% 50%, calc(100% - 14px) 100%, 0% 100%);
    padding-right: 22px;
}

/* HEXAGON — Machine group */
.dpn.shape-hexagon {
    border-radius: 0;
    clip-path: polygon(12% 0%, 88% 0%, 100% 50%, 88% 100%, 12% 100%, 0% 50%);
    padding: 6px 20px;
    justify-content: center;
}

/* TRAPEZOID — Material/Inventory group */
.dpn.shape-trap {
    border-radius: 0;
    clip-path: polygon(8% 0%, 92% 0%, 100% 100%, 0% 100%);
    padding: 4px 18px 8px;
    height: 42px;
    align-items: flex-start;
    justify-content: center;
}

/* FLAG — Inspect/Control group */
.dpn.shape-flag {
    border-radius: 0;
    clip-path: polygon(0% 50%, 14px 0%, 100% 0%, 100% 100%, 14px 100%);
    padding-left: 22px;
    padding-right: 12px;
}

/* SHIELD — Quality/Approve group */
.dpn.shape-shield {
    border-radius: 0;
    clip-path: polygon(15% 0%, 85% 0%, 100% 25%, 100% 65%, 50% 100%, 0% 65%, 0% 25%);
    height: 48px;
    padding: 4px 14px 8px;
    align-items: flex-start;
    justify-content: center;
    font-size: 10px;
}

/* ROUND-RECT — Output/Ship group */
.dpn.shape-round {
    border-radius: 12px;
    /* pill but more rounded than default */
}
/* Shape indicator badge on each palette pill */
.dpn .shape-badge {
    position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
    font-size: 7px; font-weight: 800; opacity: .55;
    pointer-events: none; letter-spacing: .3px;
    text-transform: uppercase;
}
/* Shape legend at bottom of palette */
.pal-shape-legend { padding: 4px 6px; margin-top: 6px; border-top: 1px solid #90a4b8; }
.pal-shape-legend .psl-title { font-size: 9px; font-weight: 800; color: #3a5070; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 5px; text-align: center; }
.psl-row { display: flex; align-items: center; gap: 5px; margin-bottom: 4px; }
.psl-icon { width: 26px; height: 20px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 800; color: #fff; border-radius: 2px; }
.psl-label { font-size: 9px; color: #2a3a50; font-weight: 600; }

/* Node colors */
.n-op  { background: #6ec86e; color: #0a2a0a; }
.n-ins { background: #90c860; color: #0a2a0a; }
.n-cal { background: #70c870; color: #0a2a0a; }
.n-asm { background: #a0d888; color: #0a2a0a; }
.n-rwk { background: #f0c040; color: #3a2000; }
.n-mat { background: #f0c040; color: #3a2000; border-radius: 5px; }
.n-inv { background: #e08030; color: #fff; }
.n-sb1 { background: #e08030; color: #fff; }
.n-sb2 { background: #3090e8; color: #fff; }
.n-trc { background: #e8b830; color: #3a2000; }
.n-ctl { background: #d82020; color: #fff; }
.n-hld { background: #cc2020; color: #fff; }
.n-pri { background: #cc2020; color: #fff; }
.n-cap { background: #3858c8; color: #fff; }
.n-sim { background: #38a038; color: #fff; }
.n-qnv { background: #3878d8; color: #fff; }
.n-apr { background: #30a050; color: #fff; }
.n-fst { background: #3090d8; color: #fff; }
.n-crt { background: #5858b0; color: #fff; }
.n-out { background: #7030c0; color: #fff; border-radius: 4px; font-weight: 800; font-size: 12px; }
.n-pck { background: #8030b0; color: #fff; }
.n-shp { background: #b030a0; color: #fff; }

/* ══ COL 2 — TREE ══ */
.dir-tree {
    width: 230px;
    flex-shrink: 0;
    background: #c8d4e4;
    border-right: 2px solid #a8b8cc;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: width .22s ease;
}
.dir-tree.collapsed { width: 30px; }

.dt-hd {
    background: #8aaac8;
    border-bottom: 2px solid #6a8aaa;
    height: 36px;
    padding: 0 7px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}
.dt-hd .dt-label { font-size: 11px; font-weight: 800; color: #0a1828; flex: 1; white-space: nowrap; overflow: hidden; }
.dir-tree.collapsed .dt-label { display: none; }

.dt-tog {
    width: 20px; height: 20px; border-radius: 4px; flex-shrink: 0;
    background: rgba(0,0,0,.18); border: 1px solid rgba(0,0,0,.22);
    display: flex; align-items: center; justify-content: center;
    font-size: 9px; color: #0a1828; cursor: pointer; transition: all .15s;
}
.dt-tog:hover { background: rgba(0,0,0,.3); }

.dt-vert {
    display: none;
    writing-mode: vertical-rl; transform: rotate(180deg);
    font-size: 9px; font-weight: 800; color: #4a6888;
    text-transform: uppercase; letter-spacing: .8px;
    padding: 10px 4px; white-space: nowrap;
}
.dir-tree.collapsed .dt-vert { display: block; }

.dt-scroll { overflow-y: auto; flex: 1; }
.dt-scroll::-webkit-scrollbar { width: 3px; }
.dt-scroll::-webkit-scrollbar-thumb { background: #8aaabe; border-radius: 2px; }
.dir-tree.collapsed .dt-scroll { display: none; }

/* Parent quote */
.tp { border-bottom: 1px solid rgba(0,0,0,.07); }
.tp-hd { display: flex; align-items: center; gap: 5px; padding: 7px 7px; cursor: pointer; transition: background .1s; }
.tp-hd:hover { background: rgba(255,255,255,.28); }
.tp-hd.act   { background: rgba(255,255,255,.42); border-left: 3px solid #3a70c8; }
.tp-arr { width: 16px; height: 16px; border-radius: 3px; flex-shrink: 0; background: rgba(0,0,0,.12); border: 1px solid rgba(0,0,0,.16); display: flex; align-items: center; justify-content: center; font-size: 7px; color: #2a4060; transition: all .15s; }
.tp-arr.open { background: #3a70c8; color: #fff; border-color: #2a5aaa; }
.tp-qnum { font-family: 'DM Mono', monospace; font-size: 10px; color: #b06000; background: #fffbe0; border: 1px solid #ddb820; border-radius: 3px; padding: 1px 5px; flex-shrink: 0; }
.tp-name { font-size: 11px; font-weight: 700; color: #0a1828; flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.tp-st   { font-size: 9px; font-weight: 700; padding: 1px 5px; border-radius: 8px; flex-shrink: 0; }
.tp-st.approved { background: #dcfce7; color: #166534; }
.tp-st.sent     { background: #dbeafe; color: #1d4ed8; }
.tp-st.draft    { background: #f1f5f9; color: #64748b; }

/* Parent info panel */
.tp-info { display: none; background: rgba(255,255,255,.52); border-top: 1px solid rgba(0,0,0,.07); padding: 8px 9px; }
.tp-info.open { display: block; }
.ti-row { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px; }
.ti-row:last-child { margin-bottom: 0; }
.ti-lbl { font-size: 10px; color: #4a6888; font-weight: 600; }
.ti-val { font-size: 10px; font-weight: 700; color: #0a1828; }
.ti-chips { display: flex; flex-wrap: wrap; gap: 3px; margin-top: 7px; }
.tic { font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 8px; display: flex; align-items: center; gap: 3px; }
.tic.h  { background: #e0f2fe; color: #0369a1; }
.tic.t  { background: #fce7f3; color: #9d174d; }
.tic.mc { background: #dbeafe; color: #1d4ed8; }
.tic.op { background: #f3e8ff; color: #6d28d9; }
.tic.th { background: #d1fae5; color: #065f46; }
.tic.it { background: #fef3c7; color: #92400e; }

/* Children */
.tc-wrap { display: none; }
.tc-wrap.open { display: block; }
.tc { border-bottom: 1px solid rgba(0,0,0,.05); border-left: 3px solid transparent; transition: all .1s; }
.tc:hover { background: rgba(255,255,255,.2); }
.tc.act   { background: rgba(37,99,235,.1); border-left-color: #3a70c8; }
.tc-hd    { display: flex; align-items: center; gap: 5px; padding: 6px 7px 6px 12px; cursor: pointer; }
.tc-dot   { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.tc-dot.pending  { background: #f59e0b; }
.tc-dot.assigned { background: #3a70c8; }
.tc-dot.released { background: #16a34a; }
.tc-jnum { font-family: 'DM Mono', monospace; font-size: 9px; color: #3a70c8; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 3px; padding: 1px 4px; flex-shrink: 0; }
.tc-name { font-size: 10px; font-weight: 700; color: #1a2540; flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.tc-chv  { font-size: 8px; color: #94a3b8; flex-shrink: 0; transition: transform .15s; }
.tc-chv.open { transform: rotate(90deg); color: #3a70c8; }

/* Child info panel */
.tc-info { display: none; background: rgba(255,255,255,.55); border-top: 1px solid rgba(0,0,0,.06); padding: 7px 9px 7px 12px; }
.tc-info.open { display: block; }
.ci-row { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px; }
.ci-row:last-child { margin-bottom: 0; }
.ci-lbl { font-size: 9px; color: #4a6888; font-weight: 600; }
.ci-val { font-size: 9px; font-weight: 700; color: #1a2540; }
.ci-chips { display: flex; flex-wrap: wrap; gap: 3px; margin: 6px 0; }
.cic { font-size: 9px; font-weight: 700; padding: 1px 5px; border-radius: 6px; display: flex; align-items: center; gap: 2px; }
.cic.h  { background: #e0f2fe; color: #0369a1; }
.cic.t  { background: #fce7f3; color: #9d174d; }
.cic.m  { background: #dbeafe; color: #1d4ed8; }
.cic.o  { background: #f3e8ff; color: #6d28d9; }
.cic.th { background: #d1fae5; color: #065f46; }
.no-assign { display: flex; align-items: center; gap: 4px; padding: 4px 6px; border-radius: 4px; background: #fef3c7; border: 1px solid #fde68a; font-size: 9px; font-weight: 700; color: #92400e; margin-bottom: 5px; }
.load-btn { width: 100%; padding: 5px 8px; border-radius: 5px; font-size: 10px; font-weight: 700; background: #3a70c8; color: #fff; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; display: flex; align-items: center; justify-content: center; gap: 4px; transition: background .1s; margin-top: 4px; }
.load-btn:hover { background: #2a5aaa; }
.load-btn.amber { background: #d97706; }
.load-btn.amber:hover { background: #b45309; }

/* ══ COL 3 — QUOTE INPUT ══
   Deliberately different look from palette (col1):
   diagonal stripe pattern + warm amber tone = "from quote/order data"
   Palette is cool grey/blue = "structure nodes"
══ */
.dir-in {
    width: 110px;
    flex-shrink: 0;
    /* diagonal stripe background — visually distinct from palette */
    background:
        repeating-linear-gradient(
            -45deg,
            #f5e8c8,
            #f5e8c8 5px,
            #eed8a0 5px,
            #eed8a0 10px
        );
    border-right: 3px solid #c8a840;
    border-left: 2px solid #d4b050;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.di-hd {
    background: #b8860a;
    border-bottom: 2px solid #9a7000;
    padding: 6px 6px;
    font-size: 9px;
    font-weight: 800;
    color: #fff;
    text-align: center;
    line-height: 1.4;
    flex-shrink: 0;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.di-list { overflow-y: auto; flex: 1; padding: 5px 4px; }
.di-list::-webkit-scrollbar { width: 3px; }
.di-list::-webkit-scrollbar-thumb { background: #c8a840; border-radius: 2px; }
.qi {
    padding: 5px 10px;
    border-radius: 20px;    /* OVAL/PILL — stays pill in col3, becomes arrow in lane */
    font-size: 10px;
    font-weight: 700;
    margin-bottom: 5px;
    cursor: grab;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,.18);
    user-select: none;
    transition: filter .12s, transform .12s;
    border: 2px solid rgba(0,0,0,.2);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    background: #fff;
    color: #1a2540;
}
.qi:hover  { filter: brightness(.88); transform: translateY(-1px); }
.qi:active { cursor: grabbing; opacity: .7; }

/* Per-type colors — FULL color pill (col3 items match their type color) */
.qi[data-type="hole"]    { background: #3090e8; color: #fff;    border-color: #1870c8; }
.qi[data-type="tap"]     { background: #d83060; color: #fff;    border-color: #b01848; }
.qi[data-type="machine"] { background: #2860b8; color: #fff;    border-color: #1040a0; }
.qi[data-type="op"]      { background: #6ec86e; color: #0a2a0a; border-color: #469846; }
.qi[data-type="thread"]  { background: #38a068; color: #fff;    border-color: #208050; }
.qi[data-type="item"]    { background: #f0c040; color: #3a2000; border-color: #d0a020; }

/* Used/placed — strikethrough, semi-transparent */
.qi.qi-used {
    cursor: default;
    background: rgba(255,255,255,.5) !important;
    border-color: #c8b880 !important;
    color: #a08840 !important;
    pointer-events: none;
    opacity: .55;
    box-shadow: none;
}

/* ══ COL 4 — FLOW CANVAS ══ */
.dir-cv {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #dce4f0;
    min-width: 0;
}
.dc-hd { background: #b0bece; border-bottom: 2px solid #98aabf; padding: 4px 12px; display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
.dc-hd .dc-fl { font-size: 12px; font-weight: 700; color: #3a5070; flex: 1; text-align: center; }
.dc-qref { font-family: 'DM Mono', monospace; font-size: 11px; color: #c07000; background: #fff8e0; border: 1px solid #ddb820; border-radius: 4px; padding: 1px 7px; }
.dc-body { flex: 1; overflow: auto; padding: 14px 14px 30px; min-width: 0; }
.dc-body::-webkit-scrollbar { width: 5px; height: 5px; }
.dc-body::-webkit-scrollbar-thumb { background: #a0b0c4; border-radius: 3px; }

/* Flow row & connector */
.dc-gap  { height: 14px; display: flex; align-items: center; padding-left: 38px; }
.dc-gap i { font-size: 12px; color: #8898aa; }
.dc-row  { display: flex; align-items: center; gap: 0; min-height: 46px; position: relative; }
.dc-lbl  { width: 38px; flex-shrink: 0; font-size: 9px; font-weight: 700; color: #7a8898; writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; text-transform: uppercase; letter-spacing: .5px; }

/* Pentagon step */
.dstep {
    height: 42px; min-width: 72px; padding: 0 20px 0 22px;
    display: flex; align-items: center; justify-content: center; gap: 4px;
    font-size: 11px; font-weight: 700; color: #1a2a3a;
    cursor: pointer; flex-shrink: 0;
    clip-path: polygon(0 0, calc(100% - 13px) 0, 100% 50%, calc(100% - 13px) 100%, 0 100%, 13px 50%);
    transition: filter .12s, transform .12s;
    user-select: none;
}
.dstep.fs  { clip-path: polygon(0 0, calc(100% - 13px) 0, 100% 50%, calc(100% - 13px) 100%, 0 100%); padding-left: 12px; }
.dstep:hover { filter: brightness(.88); transform: translateY(-2px); }
.dstep.sel { outline: 3px solid #2060c8; outline-offset: 1px; z-index: 2; }
.dstep.dov { outline: 2px dashed #3060c8; filter: brightness(.82); }
.dstep i   { font-size: 9px; opacity: .85; }
.dc-row.rdov .dstep.ss-blank { background: #c8d8f8; }

.ss-start   { background: #b0c0d0; color: #1a2a3a; }
.ss-inv     { background: #e07820; color: #fff; }
.ss-pick    { background: #b8cce0; color: #1a2a3a; }
.ss-hole    { background: #5898d8; color: #fff; }
.ss-tap     { background: #d83060; color: #fff; }
.ss-machine { background: #2860b8; color: #fff; }
.ss-op      { background: #50a050; color: #fff; }
.ss-item    { background: #d8a010; color: #fff; }
.ss-thread  { background: #38a068; color: #fff; }
.ss-plating { background: #b878d0; color: #fff; }
.ss-heat    { background: #d86020; color: #fff; }
.ss-inspect { background: #c86020; color: #fff; }
.ss-approve { background: #289860; color: #fff; }
.ss-ship    { background: #7030b8; color: #fff; }
.ss-pack    { background: #8030a0; color: #fff; }
.ss-stop    { background: #607080; color: #fff; }
.ss-blank   { background: #e0e8f4; color: #9aaabb; border: 1px dashed #b0c0d0; }

/* Actor */
.dactor { display: flex; flex-direction: column; align-items: center; gap: 0; margin: 0 5px; cursor: pointer; flex-shrink: 0; }
.da-head { width: 14px; height: 14px; border-radius: 50%; border: 2px solid #5a7090; background: #d0dcea; }
.da-torso { position: relative; margin-top: 1px; }
.da-body  { width: 2px; height: 14px; background: #5a7090; margin: 0 auto; }
.da-arms  { position: absolute; top: 4px; left: 50%; transform: translateX(-50%); width: 20px; height: 2px; background: #5a7090; }
.da-legs  { display: flex; gap: 5px; margin-top: 1px; }
.da-leg   { width: 2px; height: 11px; background: #5a7090; }
.da-leg.l { transform: rotate(-12deg); transform-origin: top center; }
.da-leg.r { transform: rotate(12deg); transform-origin: top center; }
.da-name  { font-size: 9px; color: #5a7090; font-weight: 600; margin-top: 2px; text-align: center; }
.dactor:hover .da-head { border-color: #3060c8; background: #b8d8f8; }

/* Speech bubble */
.dbbl { background: #fff; border: 1.5px solid #a0b0c4; border-radius: 8px; padding: 6px 10px; font-size: 10px; color: #2a3a4a; max-width: 155px; box-shadow: 0 2px 8px rgba(0,0,0,.1); margin: 0 7px; flex-shrink: 0; position: relative; line-height: 1.4; }
.dbbl::after  { content: ''; position: absolute; bottom: -9px; left: 16px; border: 5px solid transparent; border-top-color: #fff; }
.dbbl::before { content: ''; position: absolute; bottom: -11px; left: 15px; border: 6px solid transparent; border-top-color: #a0b0c4; }

/* Tracking box */
.d-tracking { background: #fff; border: 2px solid #90a8c0; border-radius: 8px; padding: 12px 18px; font-size: 13px; font-weight: 700; color: #2a3a4a; min-width: 200px; margin-left: 16px; flex-shrink: 0; box-shadow: 0 2px 10px rgba(0,0,0,.07); display: flex; align-items: center; justify-content: center; }

/* Add row button */
.dc-addrow { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 6px; font-size: 11px; font-weight: 700; background: #c0d0e0; border: 2px dashed #88a0b8; color: #3a5070; cursor: pointer; transition: all .12s; }
.dc-addrow:hover { background: #a8c0d8; }
/* ══ SWIM POOL & LANES ══ */
.swim-pool {
    display: flex;
    flex-direction: column;
    gap: 0;
    width: 100%;
    padding-bottom: 20px;
}

/* Each swim lane — strong dividers so lanes cannot be crossed */
.swim-lane {
    border-left:   3px solid #8098b8;
    border-right:  3px solid #8098b8;
    border-top:    none;
    border-bottom: 3px solid #5a7090;   /* thick bottom = hard lane boundary */
    background: #eaf0f8;
    transition: background .15s, border-color .15s;
    width: 100%;
    position: relative;
}
/* Top border on first lane */
.swim-lane:first-child { border-top: 3px solid #8098b8; }
/* Focused lane highlight */
.swim-lane.lane-focus {
    background: #f0f6ff;
    border-color: #3a70c8;
    border-bottom-color: #2050a0;
    z-index: 1;
    box-shadow: inset 0 0 0 2px rgba(58,112,200,.2);
}
/* Lane label tab on the left edge */
.swim-lane::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #6a88b8, #4a6890);
}
.swim-lane.lane-focus::before { background: linear-gradient(to bottom, #3a70c8, #2050a0); }

/* Lane header */
.lane-hd {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px 10px;
    background: rgba(0,0,0,.06);
    border-bottom: 1px solid rgba(0,0,0,.08);
    cursor: pointer;
    min-height: 34px;
    flex-shrink: 0;
}
.swim-lane.lane-focus .lane-hd { background: rgba(58,112,200,.1); }
.lane-hd:hover { background: rgba(0,0,0,.1); }
.lane-hd-left  { display: flex; align-items: center; gap: 7px; flex: 1; overflow: hidden; }
.lane-hd-right { display: flex; align-items: center; gap: 5px; flex-shrink: 0; margin-left: 10px; }

.lane-dot   { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
.lane-jnum  { font-family: 'DM Mono', monospace; font-size: 10px; color: #3a70c8; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 3px; padding: 1px 5px; flex-shrink: 0; }
.lane-jname { font-size: 12px; font-weight: 700; color: #1a2540; white-space: nowrap; }
.lane-qname { font-size: 10px; color: #7a8898; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lane-status { font-size: 10px; font-weight: 700; white-space: nowrap; }

.lane-assign-btn {
    padding: 3px 9px; border-radius: 4px; font-size: 10px; font-weight: 700;
    background: #1a2540; color: #fff; border: none; cursor: pointer;
    font-family: 'DM Sans', sans-serif; display: flex; align-items: center; gap: 4px;
    transition: background .1s; white-space: nowrap;
}
.lane-assign-btn:hover { background: #3a70c8; }
.lane-rm-btn {
    width: 22px; height: 22px; border-radius: 4px; border: 1px solid #d0daea;
    background: rgba(0,0,0,.07); color: #607080; cursor: pointer; font-size: 10px;
    display: flex; align-items: center; justify-content: center; transition: all .1s;
}
.lane-rm-btn:hover { background: #d82020; color: #fff; border-color: #d82020; }

/* Lane steps row — horizontal scroll, shapes need gap so clips don't overlap */
.lane-steps {
    display: flex;
    align-items: center;
    padding: 14px 16px 16px;
    gap: 10px;           /* wider gap — shapes like diamond/hexagon need space */
    overflow-x: auto;
    overflow-y: visible; /* allow tall shapes like diamond to show */
    min-height: 72px;
    flex-wrap: nowrap;
    width: 100%;
    box-sizing: border-box;
}
.lane-steps::-webkit-scrollbar { height: 5px; }
.lane-steps::-webkit-scrollbar-track { background: rgba(0,0,0,.05); border-radius: 3px; }
.lane-steps::-webkit-scrollbar-thumb { background: #a0b0c4; border-radius: 3px; }
.lane-steps.ldov { background: rgba(58,112,200,.08); outline: 2px dashed #3a70c8; outline-offset: -3px; }

/* Add-slot button inside the lane steps area */
.lane-add-slot-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px;
    border-radius: 20px;
    border: 2px dashed #90a8c8;
    background: transparent;
    color: #6088b0;
    font-size: 11px; font-weight: 700;
    cursor: pointer;
    transition: all .12s;
    font-family: 'DM Sans', sans-serif;
    height: 36px;
    flex-shrink: 0;
    margin-top: 0;
}
.lane-add-slot-btn:hover {
    background: #e8f0fc;
    border-color: #3a70c8;
    color: #3a70c8;
}

/* Empty state */
.canvas-empty {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; height: 220px;
    color: #8898aa; font-size: 13px; font-weight: 600; gap: 12px;
}

/* ══════════════════════════════════════════════════════════════
   LANE STEPS — MULTI-SHAPE SYSTEM
   Base has NO clip-path. Each shape class sets its own clip-path.
   This fixes CSS specificity so shapes actually apply.
══════════════════════════════════════════════════════════════ */

/* ── BASE: layout only, NO clip-path here ── */
.lane-steps .dstep {
    height: 44px;
    min-width: 88px;
    font-size: 11px;
    font-weight: 700;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    flex-shrink: 0;
    position: relative;
    cursor: pointer;
    user-select: none;
    transition: filter .12s, transform .12s;
    box-shadow: 0 3px 8px rgba(0,0,0,.25);
    /* NO clip-path here — set in shape classes below */
}
.lane-steps .dstep span { white-space: nowrap; pointer-events: none; }
.lane-steps .dstep i    { pointer-events: none; font-size: 11px; opacity: .92; }

/* ════════════════════════
   SHAPE CLASSES
   Each has full specificity: .lane-steps .dstep.ss-shape-*
════════════════════════ */

/* ARROW chevron → Operation, Start default */
.lane-steps .dstep.ss-shape-arrow {
    clip-path: polygon(0% 0%, calc(100% - 16px) 0%, 100% 50%, calc(100% - 16px) 100%, 0% 100%);
    padding: 0 24px 0 14px;
    border-radius: 0;
}

/* ARROW-FIRST flat-left pointed-right → Start */
.lane-steps .dstep.ss-shape-arrow-first {
    clip-path: polygon(0% 0%, calc(100% - 16px) 0%, 100% 50%, calc(100% - 16px) 100%, 0% 100%);
    padding: 0 24px 0 12px;
    border-radius: 0;
}

/* ARROW-END notched-left flat-right → Ship */
.lane-steps .dstep.ss-shape-arrow-end {
    clip-path: polygon(16px 0%, 100% 0%, 100% 100%, 16px 100%, 0% 50%);
    padding: 0 14px 0 26px;
    border-radius: 0;
}

/* CIRCLE pill → Hole */
.lane-steps .dstep.ss-shape-circle {
    clip-path: none;
    border-radius: 999px;
    min-width: 90px;
    border: 2px solid rgba(255,255,255,.4) !important;
}

/* DIAMOND → Tap */
.lane-steps .dstep.ss-shape-diamond {
    clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
    height: 62px;
    min-width: 62px;
    padding: 0 6px;
    font-size: 9px;
    border-radius: 0;
}

/* HEXAGON → Machine */
.lane-steps .dstep.ss-shape-hexagon {
    clip-path: polygon(15% 0%, 85% 0%, 100% 50%, 85% 100%, 15% 100%, 0% 50%);
    padding: 0 22px;
    min-width: 92px;
    border-radius: 0;
}

/* PARALLELOGRAM slanted → Thread */
.lane-steps .dstep.ss-shape-parallelogram {
    clip-path: polygon(14% 0%, 100% 0%, 86% 100%, 0% 100%);
    padding: 0 22px 0 20px;
    min-width: 92px;
    border-radius: 0;
}

/* FLAG notched-left banner → Inspect */
.lane-steps .dstep.ss-shape-flag {
    clip-path: polygon(0% 50%, 16px 0%, 100% 0%, 100% 100%, 16px 100%);
    padding: 0 16px 0 28px;
    min-width: 92px;
    border-radius: 0;
}

/* SHIELD badge → Approve, Cert */
.lane-steps .dstep.ss-shape-shield {
    clip-path: polygon(15% 0%, 85% 0%, 100% 25%, 100% 65%, 50% 100%, 0% 65%, 0% 25%);
    height: 56px;
    min-width: 64px;
    padding: 4px 10px 0;
    font-size: 9px;
    border-radius: 0;
    align-items: flex-start;
}

/* HOUSE pointed-top → Inventory */
.lane-steps .dstep.ss-shape-house {
    clip-path: polygon(50% 0%, 100% 35%, 100% 100%, 0% 100%, 0% 35%);
    height: 56px;
    min-width: 64px;
    padding: 10px 10px 4px;
    font-size: 9px;
    border-radius: 0;
    align-items: flex-end;
}

/* TRAPEZOID wide-bottom → Heat Treat */
.lane-steps .dstep.ss-shape-trapezoid {
    clip-path: polygon(12% 0%, 88% 0%, 100% 100%, 0% 100%);
    padding: 0 18px;
    min-width: 88px;
    border-radius: 0;
}

/* ROUND-RECT → Plating, Pack */
.lane-steps .dstep.ss-shape-round-rect {
    clip-path: none;
    border-radius: 12px;
    border: 2px solid rgba(255,255,255,.3) !important;
}

/* STOP square → Control, Hold */
.lane-steps .dstep.ss-shape-stop {
    clip-path: none;
    border-radius: 4px;
    border: 3px solid rgba(255,255,255,.25) !important;
    min-width: 76px;
}

/* OCTAGON cut-corners → Item */
.lane-steps .dstep.ss-shape-octagon {
    clip-path: polygon(12% 0%,88% 0%,100% 12%,100% 88%,88% 100%,12% 100%,0% 88%,0% 12%);
    padding: 0 14px;
    min-width: 84px;
    border-radius: 0;
}

/* ── COLORS ── */
.lane-steps .ss-start   { background: #b0c0d0; color: #1a2a3a; }
.lane-steps .ss-ship    { background: #c0306a; color: #fff; }
.lane-steps .ss-pack    { background: #8030a0; color: #fff; }
.lane-steps .ss-hole    { background: #3090e8; color: #fff; }
.lane-steps .ss-tap     { background: #d83060; color: #fff; }
.lane-steps .ss-machine { background: #2860b8; color: #fff; }
.lane-steps .ss-op      { background: #50a850; color: #fff; }
.lane-steps .ss-item    { background: #f0c040; color: #3a2000; }
.lane-steps .ss-thread  { background: #38a068; color: #fff; }
.lane-steps .ss-inv     { background: #e08030; color: #fff; }
.lane-steps .ss-plating { background: #b878d0; color: #fff; }
.lane-steps .ss-heat    { background: #d86020; color: #fff; }
.lane-steps .ss-inspect { background: #90c860; color: #0a2a0a; }
.lane-steps .ss-approve { background: #30a050; color: #fff; }
.lane-steps .ss-stop    { background: #d82020; color: #fff; }
.lane-steps .ss-cert    { background: #3060b8; color: #fff; }

/* Locked */
.lane-steps .dstep.step-locked { cursor: default; }
.lane-steps .dstep.step-locked:hover { filter: none; transform: none; }

/* Hover/drag */
.lane-steps .dstep:not(.step-locked):not(.step-blank):hover {
    filter: brightness(.88); transform: translateY(-2px); cursor: grab; z-index: 2;
}
.lane-steps .dstep.dov {
    filter: brightness(.72); z-index: 3; outline: 3px dashed #3a70c8; outline-offset: 3px;
}

/* ── BLANK DROP SLOT — always visible rectangle ── */
.lane-steps .dstep.step-blank,
.dstep.step-blank {
    clip-path: none !important;
    border-radius: 8px !important;
    background: rgba(255,255,255,.7) !important;
    border: 2px dashed #90a8c8 !important;
    color: #90a8c8 !important;
    min-width: 80px !important;
    width: 80px !important;
    height: 40px !important;
    opacity: .8;
    box-shadow: none !important;
    font-size: 10px;
    justify-content: center;
    flex-shrink: 0;
}
.lane-steps .dstep.step-blank:hover, .dstep.step-blank:hover {
    opacity: 1; border-color: #3a70c8 !important; background: #eff6ff !important;
}
.lane-steps .dstep.step-blank.dov, .dstep.step-blank.dov {
    opacity: 1; border-color: #3a70c8 !important; border-style: solid !important; background: #dbeafe !important;
}


/* ══ ASSIGN MODAL ══ */
.dir-overlay { position: fixed; inset: 0; background: rgba(10,20,40,.45); z-index: 1060; display: none; align-items: center; justify-content: center; backdrop-filter: blur(3px); }
.dir-overlay.on { display: flex; }
.dir-mbox { background: #fff; border-radius: 12px; width: 480px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.22); animation: dir-pop .18s ease; }
@@keyframes dir-pop { from { transform: scale(.94); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.dir-mhd { background: #1a2540; padding: 13px 18px; display: flex; align-items: center; gap: 8px; }
.dir-mhd .dmt { font-size: 14px; font-weight: 700; color: #fff; flex: 1; }
.dir-mhd .dmx { width: 26px; height: 26px; border-radius: 6px; background: rgba(255,255,255,.12); border: none; cursor: pointer; color: rgba(255,255,255,.7); font-size: 11px; display: flex; align-items: center; justify-content: center; }
.dir-mbd { padding: 18px; }
.dir-mf  { margin-bottom: 12px; }
.dir-mf label { display: block; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 4px; }
.dir-mf select, .dir-mf input { width: 100%; padding: 8px 10px; border-radius: 7px; border: 1px solid #e2e8f0; font-size: 13px; font-family: 'DM Sans', sans-serif; outline: none; }
.dir-mf select:focus, .dir-mf input:focus { border-color: #3a70c8; }
.dir-mft { padding: 10px 18px 16px; display: flex; gap: 7px; justify-content: flex-end; }
.dir-mftb { padding: 8px 18px; border-radius: 8px; font-size: 12px; font-weight: 700; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; display: flex; align-items: center; gap: 5px; }
.dir-mftb.cl { background: #f1f5f9; color: #475569; }
.dir-mftb.sv { background: #1a2540; color: #fff; }
.dir-mftb.rl { background: #16a34a; color: #fff; }

/* Toast */
#dir-toast { position: fixed; bottom: 16px; left: 50%; transform: translateX(-50%) translateY(8px); z-index: 1070; background: #1a2540; color: #fff; border-left: 3px solid #22c55e; border-radius: 20px; padding: 8px 18px; font-size: 12px; font-weight: 700; font-family: 'DM Sans', sans-serif; display: none; align-items: center; gap: 7px; box-shadow: 0 4px 20px rgba(0,0,0,.2); }
#dir-toast.on { display: flex; transform: translateX(-50%) translateY(0); }
</style>
@endsection

@section('content')
{{-- Adds director-page class to body for full-height layout --}}
<script>document.body.classList.add('director-page');</script>

{{-- Director Top Bar — matches app nav style --}}
<div class="dir-topbar">
    <a href="{{ route('company.quotes.index') }}" class="dt-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    <div class="dt-title">
        <i class="fas fa-industry" style="margin-right:6px;opacity:.7;"></i>
        The Director Main Screen &mdash; Parent or Child Item #
    </div>
    <button class="dtbtn">
        <i class="fas fa-save" style="margin-right:4px;"></i>Save Draft
    </button>
    <button class="dtbtn blue">
        <i class="fas fa-eye" style="margin-right:4px;"></i>Preview
    </button>
    <button class="dtbtn green" onclick="dirShowModal(null)">
        <i class="fas fa-paper-plane" style="margin-right:4px;"></i>Release
    </button>
</div>

{{-- 4-Column Shell --}}
<div class="dir-shell">

    {{-- ══ COL 1 — NODE PALETTE ══ --}}
    <div class="dir-pal">
        <div class="dp-sec">STRUCTURE</div>
        <div class="dp-cg">
            <button class="dp-cb dg" onclick="dirAddRow()">+ ADD</button>
            <button class="dp-cb" onclick="dirRemoveRow()">− Minus</button>
            <button class="dp-cb">⊟ Remove</button>
            <button class="dp-cb">⊞ Split</button>
            <button class="dp-cb">⟳ MERGE</button>
            <button class="dp-cb">↕ REORDER</button>
        </div>

        {{-- ══ GROUP 1: ARROW shape — Process/Operation (green) ══ --}}
        <div class="dp-sec" style="background:#3a7a3a;color:#fff;border-color:#2a6a2a;">▶ PROCESS</div>
        <div class="dpn n-op shape-arrow" draggable="true" ondragstart="dirDn(event,'op','Operation','ss-op','fa-tools')">
            <i class="fas fa-tools"></i> Operation
        </div>
        <div class="dpn-row">
            <div class="dpn n-cal shape-arrow" draggable="true" ondragstart="dirDn(event,'op','Calibrate','ss-op','fa-sliders-h')"><i class="fas fa-sliders-h"></i>Calibrate</div>
            <div class="dpn n-asm shape-arrow" draggable="true" ondragstart="dirDn(event,'op','Assemble','ss-op','fa-puzzle-piece')"><i class="fas fa-puzzle-piece"></i>Assemble</div>
        </div>
        <div class="dpn n-rwk shape-arrow" draggable="true" ondragstart="dirDn(event,'op','Rework','ss-op','fa-redo')">
            <i class="fas fa-redo"></i> Rework
        </div>

        {{-- ══ GROUP 2: HEXAGON — Machine/Equipment (blue) ══ --}}
        <div class="dp-sec" style="background:#2050a0;color:#fff;border-color:#104088;">⬡ MACHINE</div>
        <div class="dpn n-machine shape-hexagon" style="background:#2860b8;color:#fff;" draggable="true" ondragstart="dirDn(event,'machine','Machine','ss-machine','fa-cog')">
            <i class="fas fa-cog"></i> Machine
        </div>
        <div class="dpn-row">
            <div class="dpn n-cap shape-hexagon" style="background:#3878c8;color:#fff;" draggable="true" ondragstart="dirDn(event,'machine','Capacity','ss-machine','fa-chart-bar')"><i class="fas fa-chart-bar"></i>Capacity</div>
            <div class="dpn n-sim shape-hexagon" style="background:#3060b8;color:#fff;" draggable="true" ondragstart="dirDn(event,'machine','Simulate','ss-machine','fa-play')"><i class="fas fa-play"></i>Simulate</div>
        </div>

        {{-- ══ GROUP 3: TRAPEZOID — Material/Inventory (orange) ══ --}}
        <div class="dp-sec" style="background:#c07010;color:#fff;border-color:#a05800;">⬠ MATERIAL</div>
        <div class="dpn n-mat shape-trap" style="background:#f0c040;color:#3a2000;" draggable="true" ondragstart="dirDn(event,'item','MATERIAL ABER','ss-item','fa-cube')">
            MATERIAL ABER
        </div>
        <div class="dpn-row">
            <div class="dpn n-inv shape-trap" style="background:#e08030;color:#fff;" draggable="true" ondragstart="dirDn(event,'inventory','Inventory','ss-inv','fa-boxes')"><i class="fas fa-boxes"></i>Inventory</div>
            <div class="dpn n-trc shape-trap" style="background:#d09030;color:#fff;" draggable="true" ondragstart="dirDn(event,'op','Trace','ss-op','fa-route')"><i class="fas fa-route"></i>Trace</div>
        </div>
        <div class="dpn-row">
            <div class="dpn n-sb1 shape-trap" style="background:#e07820;color:#fff;" draggable="true" ondragstart="dirDn(event,'inventory','Substitute','ss-inv','fa-exchange-alt')"><i class="fas fa-exchange-alt"></i>Subst.</div>
            <div class="dpn n-heat shape-trap" style="background:#d86020;color:#fff;" draggable="true" ondragstart="dirDn(event,'heat','Heat Treat','ss-heat','fa-fire')"><i class="fas fa-fire"></i>Heat</div>
        </div>

        {{-- ══ GROUP 4: FLAG — Inspect/Control (red) ══ --}}
        <div class="dp-sec" style="background:#b02020;color:#fff;border-color:#901010;">⚑ CONTROL</div>
        <div class="dpn n-ins shape-flag" style="background:#90c860;color:#0a2a0a;" draggable="true" ondragstart="dirDn(event,'inspect','Inspect','ss-inspect','fa-search')">
            <i class="fas fa-search"></i> Inspect
        </div>
        <div class="dpn n-ctl shape-flag" style="background:#d82020;color:#fff;" draggable="true" ondragstart="dirDn(event,'control','Control (Red)','ss-stop','fa-stop-circle')">
            <i class="fas fa-stop-circle"></i> Control
        </div>
        <div class="dpn-row">
            <div class="dpn n-hld shape-flag" style="background:#cc2020;color:#fff;" draggable="true" ondragstart="dirDn(event,'hold','Hold','ss-stop','fa-pause')"><i class="fas fa-pause"></i>Hold</div>
            <div class="dpn n-pri shape-flag" style="background:#cc2020;color:#fff;" draggable="true" ondragstart="dirDn(event,'hold','Priority','ss-stop','fa-flag')"><i class="fas fa-flag"></i>Priority</div>
        </div>

        {{-- ══ GROUP 5: SHIELD — Quality/Approve (teal/green) ══ --}}
        <div class="dp-sec" style="background:#1a7040;color:#fff;border-color:#0a5030;">🛡 QUALITY</div>
        <div class="dpn n-qnv shape-shield" style="background:#3878d8;color:#fff;" draggable="true" ondragstart="dirDn(event,'approve','Quality Nav','ss-approve','fa-star')">
            <i class="fas fa-star"></i>&nbsp;Quality Nav
        </div>
        <div class="dpn-row">
            <div class="dpn n-apr shape-shield" style="background:#30a050;color:#fff;" draggable="true" ondragstart="dirDn(event,'approve','Approve','ss-approve','fa-check')"><i class="fas fa-check"></i>Approve</div>
            <div class="dpn n-fst shape-shield" style="background:#2888c8;color:#fff;" draggable="true" ondragstart="dirDn(event,'approve','1st Article','ss-approve','fa-file-alt')"><i class="fas fa-file-alt"></i>1st Art.</div>
        </div>
        <div class="dpn n-crt shape-shield" style="background:#5858b0;color:#fff;" draggable="true" ondragstart="dirDn(event,'cert','Cert Required','ss-cert','fa-certificate')">
            <i class="fas fa-certificate"></i>&nbsp;Cert Required
        </div>

        {{-- ══ GROUP 6: ROUND-RECT — Output/Pack/Ship (purple) ══ --}}
        <div class="dp-sec" style="background:#6020a0;color:#fff;border-color:#501888;">◉ OUTPUT</div>
        <div class="dpn n-out shape-round" style="background:#7030c0;color:#fff;justify-content:center;" draggable="true" ondragstart="dirDn(event,'plating','Plating','ss-plating','fa-paint-brush')">
            <i class="fas fa-paint-brush"></i>&nbsp;Plating
        </div>
        <div class="dpn-row">
            <div class="dpn n-pck shape-round" style="background:#8030a0;color:#fff;" draggable="true" ondragstart="dirDn(event,'pack','Pack','ss-pack','fa-box-open')"><i class="fas fa-box-open"></i>Pack</div>
            <div class="dpn n-shp shape-round" style="background:#b030a0;color:#fff;" draggable="true" ondragstart="dirDn(event,'ship','Ship','ss-ship','fa-truck')"><i class="fas fa-truck"></i>Ship</div>
        </div>
        <div style="height:6px;"></div>
        <div style="font-size:8px;color:#5a7090;text-align:center;border-top:1px solid #90a4b8;padding-top:5px;line-height:1.4;">info from the Quote form/Order Input</div>

        {{-- ═══ SHAPE LEGEND ═══ --}}
        <div class="pal-shape-legend">
            <div class="psl-title"><i class="fas fa-shapes"></i> Lane Shape Guide</div>
            <div class="psl-row"><div class="psl-icon" style="background:#3090e8;border-radius:50%;width:20px;height:20px;"></div><div class="psl-label">Circle = Hole</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#d83060;clip-path:polygon(50% 0%,100% 50%,50% 100%,0% 50%);border-radius:0;"></div><div class="psl-label">Diamond = Tap</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#2860b8;clip-path:polygon(15% 0%,85% 0%,100% 50%,85% 100%,15% 100%,0% 50%);border-radius:0;"></div><div class="psl-label">Hexagon = Machine</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#50a850;clip-path:polygon(0 0,calc(100% - 7px) 0,100% 50%,calc(100% - 7px) 100%,0 100%);border-radius:0;"></div><div class="psl-label">Arrow = Operation</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#38a068;clip-path:polygon(10% 0%,100% 0%,90% 100%,0% 100%);border-radius:0;"></div><div class="psl-label">Slant = Thread</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#f0c040;border-radius:4px;"></div><div class="psl-label">Rect = Item</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#90c860;clip-path:polygon(0 50%,7px 0,100% 0,100% 100%,7px 100%);border-radius:0;"></div><div class="psl-label">Flag = Inspect</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#30a050;clip-path:polygon(15% 0%,85% 0%,100% 30%,100% 70%,50% 100%,0% 70%,0% 30%);height:22px;border-radius:0;"></div><div class="psl-label">Shield = Approve</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#e08030;clip-path:polygon(50% 0%,100% 30%,100% 100%,0% 100%,0% 30%);height:22px;border-radius:0;"></div><div class="psl-label">House = Inventory</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#d86020;clip-path:polygon(10% 0%,90% 0%,100% 100%,0% 100%);border-radius:0;"></div><div class="psl-label">Trapezoid = Heat</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#d82020;border-radius:3px;"></div><div class="psl-label">Square = Control/Hold</div></div>
            <div class="psl-row"><div class="psl-icon" style="background:#b878d0;border-radius:6px;"></div><div class="psl-label">Pill = Plating/Pack</div></div>
        </div>
    </div>

    {{-- ══ COL 2 — QUOTE/ORDER TREE ══ --}}
    <div class="dir-tree" id="dirTree">
        <div class="dt-hd">
            <span class="dt-label">📋 Quotes &amp; Orders</span>
            <div class="dt-tog" onclick="dirToggleTree()" title="Collapse panel">
                <i class="fas fa-chevron-left" id="dirTreeIco"></i>
            </div>
        </div>
        <div class="dt-vert">Quotes &amp; Orders</div>
        <div class="dt-scroll" id="dirTreeScroll"></div>
    </div>

    {{-- ══ COL 3 — QUOTE INPUT ══ --}}
    <div class="dir-in">
        <div class="di-hd">input from<br>quote/order</div>
        <div class="di-list" id="dirInList"></div>
    </div>

    {{-- ══ COL 4 — FLOW CANVAS ══ --}}
    <div class="dir-cv">
        <div class="dc-hd">
            <span style="font-size:11px;font-weight:700;color:#4a6080;">Active:</span>
            <span class="dc-qref" id="dirActiveRef">—</span>
            <span style="font-size:11px;font-weight:600;color:#1a2540;margin-left:4px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:220px;" id="dirActiveName">Select a quote or job order</span>
            <span class="dc-fl">flow</span>
            <span style="font-size:10px;color:#5a7090;white-space:nowrap;" id="dirActiveJOs"></span>
        </div>
        <div class="dc-body">
            <div id="dirFlowWrap"></div>
        </div>
    </div>

</div>{{-- /dir-shell --}}

{{-- ══ ASSIGN MODAL ══ --}}
<div class="dir-overlay" id="dirModal">
    <div class="dir-mbox">
        <div class="dir-mhd">
            <div class="dmt"><i class="fas fa-hard-hat" style="color:#f59e0b;margin-right:6px;"></i>Assign &amp; Release Workflow</div>
            <button class="dmx" onclick="dirCloseModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="dir-mbd">
            <div style="background:#fffbe8;border:1px solid #fde68a;border-radius:8px;padding:8px 12px;margin-bottom:14px;font-size:11px;color:#92400e;">
                <i class="fas fa-info-circle" style="margin-right:5px;"></i>
                Assigning: <strong id="dirModalRef">—</strong>
            </div>
            <div class="dir-mf"><label>Machine</label>
                <select><option>— Select —</option><option>HAAS VF-4 (5-Axis Mill)</option><option>Mazak ST-20 (Lathe)</option><option>DMG VMC-500</option><option>Brother TC-S2D</option></select>
            </div>
            <div class="dir-mf"><label>Operator</label>
                <select><option>— Select —</option><option>John Smith</option><option>Maria Lopez</option><option>Dave Chen</option><option>Sarah Kim</option></select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                <div class="dir-mf"><label>Start Date</label><input type="date" value="{{ date('Y-m-d') }}"></div>
                <div class="dir-mf"><label>Priority</label>
                    <select><option>Normal</option><option>Rush</option><option>Urgent</option></select>
                </div>
            </div>
        </div>
        <div class="dir-mft">
            <button class="dir-mftb cl" onclick="dirCloseModal()">Cancel</button>
            <button class="dir-mftb sv" onclick="dirCloseModal();dirToast('Assignment saved ✓','#2563eb')"><i class="fas fa-save"></i> Save</button>
            <button class="dir-mftb rl" onclick="dirCloseModal();dirToast('Released to Shop Floor ✓','#16a34a')"><i class="fas fa-paper-plane"></i> Release</button>
        </div>
    </div>
</div>

<div id="dir-toast"><i class="fas fa-check"></i><span id="dir-toast-txt"></span></div>
@endsection

@push('scripts')
@verbatim
<script>
/* ════════════════════════════════════════
   SHOP DIRECTOR — JavaScript
════════════════════════════════════════ */

/* ── Sample data ── */
var DIR_QUOTES = [
    {
        id:'Q-000001', name:'Hydraulic Cylinder Rod', customer:'AeroTech Corp',
        qty:25, mat:'Steel 4140', status:'approved',
        holes:2, taps:1, machines:1, ops:2, threads:0, items:1,
        children:[
            { id:'JO-000001', name:'CNC Turning', status:'released',
              machine:'Mazak ST-20', operator:'John Smith', date:'Feb 20', priority:'Normal',
              holes:2, taps:1, machines:1, ops:2, threads:0, items:1 },
            { id:'JO-000002', name:'Drilling & Tapping', status:'assigned',
              machine:'Brother TC-S2D', operator:'Dave Chen', date:'Feb 22', priority:'Rush',
              holes:1, taps:2, machines:1, ops:1, threads:1, items:2 }
        ]
    },
    {
        id:'Q-000002', name:'Aerospace Mounting Bracket', customer:'Boeing Suppliers',
        qty:10, mat:'Al-6061', status:'approved',
        holes:3, taps:2, machines:1, ops:3, threads:2, items:3,
        children:[
            { id:'JO-000003', name:'5-Axis Milling', status:'pending',
              machine:null, operator:null, date:null, priority:null,
              holes:3, taps:2, machines:1, ops:3, threads:2, items:3 }
        ]
    },
    {
        id:'Q-000003', name:'Gearbox Housing', customer:'Precision Parts Inc',
        qty:5, mat:'Cast Iron', status:'sent',
        holes:4, taps:2, machines:2, ops:3, threads:1, items:2,
        children:[
            { id:'JO-000004', name:'Rough Boring', status:'pending',
              machine:null, operator:null, date:null, priority:null,
              holes:3, taps:2, machines:2, ops:3, threads:1, items:2 },
            { id:'JO-000005', name:'Final Machining', status:'pending',
              machine:null, operator:null, date:null, priority:null,
              holes:1, taps:0, machines:1, ops:1, threads:0, items:1 }
        ]
    },
    {
        id:'Q-000004', name:'Precision Shaft Assembly', customer:'Rolls-Royce LLC',
        qty:8, mat:'Ti-6Al-4V', status:'draft',
        holes:2, taps:1, machines:1, ops:2, threads:1, items:2,
        children:[
            { id:'JO-000006', name:'Turning Operation', status:'pending',
              machine:null, operator:null, date:null, priority:null,
              holes:2, taps:1, machines:1, ops:2, threads:1, items:2 }
        ]
    }
];

/* ════════════════════════════════
   STATE
════════════════════════════════ */
var DIR_LANES    = {};    // keyed by JO id
var DIR_LANE_ORD = [];    // display order
var DIR_DRAG     = null;  // current drag payload (object, not string)
var dirTreeOpen  = {};
var dirChildOpen = {};
var dirTreeCol   = false;
var dirActiveJO  = null;
var dirSelLane   = null;

/* ════════════════════════════════
   STEP DEFINITIONS
   Each item type maps to {cls, icon, label}
════════════════════════════════ */
/* shape = CSS class added to lane step for clip-path shape
   palette buttons (col1) stay as oval pills — shape only applies in lane */
var STEP_DEF = {
    start:    {cls:'ss-start',   icon:'fa-play',         label:'Start',      shape:'ss-shape-arrow-first'},
    hole:     {cls:'ss-hole',    icon:'fa-circle-notch', label:'Hole',       shape:'ss-shape-circle'},
    tap:      {cls:'ss-tap',     icon:'fa-screwdriver',  label:'Tap',        shape:'ss-shape-diamond'},
    machine:  {cls:'ss-machine', icon:'fa-cog',          label:'Machine',    shape:'ss-shape-hexagon'},
    op:       {cls:'ss-op',      icon:'fa-tools',        label:'Operation',  shape:'ss-shape-arrow'},
    thread:   {cls:'ss-thread',  icon:'fa-ring',         label:'Thread',     shape:'ss-shape-parallelogram'},
    item:     {cls:'ss-item',    icon:'fa-box',          label:'Item',       shape:'ss-shape-octagon'},
    inventory:{cls:'ss-inv',     icon:'fa-boxes',        label:'Inventory',  shape:'ss-shape-house'},
    plating:  {cls:'ss-plating', icon:'fa-paint-brush',  label:'Plating',    shape:'ss-shape-round-rect'},
    heat:     {cls:'ss-heat',    icon:'fa-fire',         label:'Heat Treat', shape:'ss-shape-trapezoid'},
    inspect:  {cls:'ss-inspect', icon:'fa-search',       label:'Inspect',    shape:'ss-shape-flag'},
    approve:  {cls:'ss-approve', icon:'fa-check',        label:'Approve',    shape:'ss-shape-shield'},
    pack:     {cls:'ss-pack',    icon:'fa-box-open',     label:'Pack',       shape:'ss-shape-round-rect'},
    ship:     {cls:'ss-ship',    icon:'fa-truck',        label:'Ship',       shape:'ss-shape-arrow-end'},
    cert:     {cls:'ss-cert',    icon:'fa-certificate',  label:'Cert',       shape:'ss-shape-shield'},
    control:  {cls:'ss-stop',    icon:'fa-stop-circle',  label:'Control',    shape:'ss-shape-stop'},
    hold:     {cls:'ss-stop',    icon:'fa-pause',        label:'Hold',       shape:'ss-shape-stop'}
};

/* Make a locked step object */
function mkLocked(type) {
    var d = STEP_DEF[type] || {cls:'ss-start', icon:'fa-play', label:type, shape:'ss-shape-arrow-first'};
    return {type:type, label:d.label, cls:d.cls, icon:d.icon, shape:d.shape||'ss-shape-arrow', locked:true};
}

/* Make a blank slot */
function mkBlank() {
    return {type:'blank', label:'', cls:'ss-blank', icon:'', shape:'', locked:false};
}

/* Make a step from a palette/input drag item */
function mkStep(type, label, cls, icon, shape) {
    var d = STEP_DEF[type] || {};
    var resolvedShape = shape || d.shape || 'ss-shape-arrow';
    return {type:type, label:label, cls:cls, icon:icon, shape:resolvedShape, locked:false};
}

/* ════════════════════════════════
   BUILD LANE STEPS
   START (locked) + N blank slots (one per JO item) + SHIP (locked)
   User drags items from col-3 into the blank slots.
════════════════════════════════ */
function dirBuildSteps(jo) {
    var steps = [];
    /* LOCKED first: Start — always visible */
    steps.push(mkLocked('start'));
    /* One blank per JO item (quota) + 4 EXTRA blanks for palette drag-ins */
    var n = jo.holes + jo.taps + jo.machines + jo.ops + jo.threads + jo.items;
    if(n < 1) n = 3;
    var total = n + 4;   /* 4 extra slots always available for Inspect, Hold, etc. */
    for(var i = 0; i < total; i++) steps.push(mkBlank());
    /* LOCKED last: Ship — always visible */
    steps.push(mkLocked('ship'));
    return steps;
}

/* Add one extra blank slot before Ship in a lane */
function dirAddSlot(joid) {
    var lane = DIR_LANES[joid];
    if(!lane) return;
    var insertAt = lane.steps.length - 1; /* before Ship */
    lane.steps.splice(insertAt, 0, mkBlank());
    dirRenderCanvas();
    dirFocusLane(joid);
    dirToast('Slot added to ' + joid, '#2563eb');
}

/* ════════════════════════════════
   BUILD INPUT PANEL ITEMS
   Returns the full list for a JO — one entry per hole/tap/machine etc.
════════════════════════════════ */
function dirBuildInputItems(jo) {
    var items = [];
    var i;
    for(i=0;i<jo.holes;i++)    items.push({type:'hole',    label:'Hole '+(i+1),    icon:'fa-circle-notch', cls:'ss-hole'});
    for(i=0;i<jo.taps;i++)     items.push({type:'tap',     label:'Tap '+(i+1),     icon:'fa-screwdriver',  cls:'ss-tap'});
    for(i=0;i<jo.machines;i++) items.push({type:'machine', label:'Machine '+(i+1), icon:'fa-cog',          cls:'ss-machine'});
    for(i=0;i<jo.ops;i++)      items.push({type:'op',      label:'Op '+(i+1),      icon:'fa-tools',        cls:'ss-op'});
    for(i=0;i<jo.threads;i++)  items.push({type:'thread',  label:'Thread '+(i+1),  icon:'fa-ring',         cls:'ss-thread'});
    for(i=0;i<jo.items;i++)    items.push({type:'item',    label:'Item '+(i+1),     icon:'fa-box',          cls:'ss-item'});
    return items;
}

/* Count how many of each type are already placed (non-blank, non-locked) in a lane */
function dirCountPlaced(joid) {
    var counts = {};
    var lane = DIR_LANES[joid];
    if(!lane) return counts;
    lane.steps.forEach(function(s) {
        if(s.locked || s.type === 'blank') return;
        counts[s.type] = (counts[s.type] || 0) + 1;
    });
    return counts;
}

/* Get the JO quota for a type in a lane (max allowed).
   Returns Infinity if the lane has no linked JO (palette-only workflow). */
function dirGetQuota(joid, type) {
    var lane = DIR_LANES[joid];
    if(!lane) return 0;
    /* Find the JO in DIR_QUOTES */
    var jo = null;
    DIR_QUOTES.forEach(function(q) {
        q.children.forEach(function(c) { if(c.id === lane.joId) jo = c; });
    });
    if(!jo) return Infinity; /* no linked JO — allow anything */
    var map = {
        hole:    jo.holes,
        tap:     jo.taps,
        machine: jo.machines,
        op:      jo.ops,
        thread:  jo.threads,
        item:    jo.items
    };
    return (map[type] !== undefined) ? (map[type] || 0) : Infinity;
}

/* Check if adding one more of `type` to `joid` lane is allowed.
   If `replacingType` is provided (a swap), that slot is freed first. */
function dirQuotaOk(joid, type, replacingType) {
    var quota = dirGetQuota(joid, type);
    if(quota === Infinity) return true;   /* palette-only types always ok */
    if(quota === 0) return false;         /* JO has none of this type */
    var placed = dirCountPlaced(joid);
    var current = placed[type] || 0;
    /* If we are replacing a slot of the same type, count stays same */
    if(replacingType === type) return true;
    return current < quota;
}

/* ════════════════════════════════
   TREE RENDER
════════════════════════════════ */
function dirRenderTree() {
    var h = '';
    DIR_QUOTES.forEach(function(q) {
        var pOpen = !!dirTreeOpen[q.id];
        var isAct = dirActiveJO && dirActiveJO._quoteId === q.id;

        h += '<div class="tp">';
        h += '<div class="tp-hd' + (isAct?' act':'') + '" onclick="dirClickParent(\'' + q.id + '\')">';
        h += '<div class="tp-arr' + (pOpen?' open':'') + '"><i class="fas fa-chevron-' + (pOpen?'down':'right') + '"></i></div>';
        h += '<span class="tp-qnum">' + q.id + '</span>';
        h += '<span class="tp-name">' + q.name + '</span>';
        h += '<span class="tp-st ' + q.status + '">' + q.status + '</span>';
        h += '</div>';

        h += '<div class="tp-info' + (pOpen?' open':'') + '">';
        h += '<div class="ti-row"><span class="ti-lbl">Customer</span><span class="ti-val">' + q.customer + '</span></div>';
        h += '<div class="ti-row"><span class="ti-lbl">Qty / Material</span><span class="ti-val">\xd7' + q.qty + ' ' + q.mat + '</span></div>';
        h += '<div class="ti-row"><span class="ti-lbl">Job Orders</span><span class="ti-val">' + q.children.length + '</span></div>';
        h += '<div class="ti-chips">';
        if(q.holes)    h += '<span class="tic h"><i class="fas fa-circle-notch"></i> ' + q.holes + ' Holes</span>';
        if(q.taps)     h += '<span class="tic t"><i class="fas fa-screwdriver"></i> ' + q.taps + ' Taps</span>';
        if(q.machines) h += '<span class="tic mc"><i class="fas fa-cog"></i> ' + q.machines + ' Mach</span>';
        if(q.ops)      h += '<span class="tic op"><i class="fas fa-tools"></i> ' + q.ops + ' Ops</span>';
        if(q.threads)  h += '<span class="tic th"><i class="fas fa-ring"></i> ' + q.threads + ' Thr</span>';
        if(q.items)    h += '<span class="tic it"><i class="fas fa-box"></i> ' + q.items + ' Items</span>';
        h += '</div></div>';

        h += '<div class="tc-wrap' + (pOpen?' open':'') + '">';
        q.children.forEach(function(jo) {
            var cOpen   = !!dirChildOpen[jo.id];
            var cAct    = dirActiveJO && dirActiveJO.id === jo.id;
            var hasLane = !!DIR_LANES[jo.id];
            var stCol   = jo.status==='released'?'#16a34a':jo.status==='assigned'?'#3a70c8':'#d97706';

            h += '<div class="tc' + (cAct?' act':'') + '">';
            h += '<div class="tc-hd" onclick="dirClickChild(\'' + jo.id + '\',\'' + q.id + '\')">';
            h += '<div class="tc-dot ' + jo.status + '"></div>';
            h += '<span class="tc-jnum">' + jo.id + '</span>';
            h += '<span class="tc-name">' + jo.name + '</span>';
            if(hasLane) h += '<span style="font-size:8px;background:#dcfce7;color:#16a34a;border-radius:4px;padding:1px 4px;flex-shrink:0;font-weight:700;margin-left:2px;">LANE</span>';
            h += '<i class="fas fa-chevron-right tc-chv' + (cOpen?' open':'') + '"></i>';
            h += '</div>';

            h += '<div class="tc-info' + (cOpen?' open':'') + '">';
            h += '<div class="ci-row"><span class="ci-lbl">Status</span><span class="ci-val" style="color:' + stCol + ';">' + jo.status + '</span></div>';
            if(jo.operator) {
                h += '<div class="ci-row"><span class="ci-lbl">Operator</span><span class="ci-val">' + jo.operator + '</span></div>';
                h += '<div class="ci-row"><span class="ci-lbl">Machine</span><span class="ci-val">' + jo.machine + '</span></div>';
                h += '<div class="ci-row"><span class="ci-lbl">Start</span><span class="ci-val">' + jo.date + '</span></div>';
            } else {
                h += '<div class="no-assign"><i class="fas fa-exclamation-triangle"></i> Not assigned yet</div>';
            }
            h += '<div class="ci-chips">';
            if(jo.holes)    h += '<span class="cic h"><i class="fas fa-circle-notch"></i> ' + jo.holes + '</span>';
            if(jo.taps)     h += '<span class="cic t"><i class="fas fa-screwdriver"></i> ' + jo.taps + '</span>';
            if(jo.machines) h += '<span class="cic m"><i class="fas fa-cog"></i> ' + jo.machines + '</span>';
            if(jo.ops)      h += '<span class="cic o"><i class="fas fa-tools"></i> ' + jo.ops + '</span>';
            if(jo.threads)  h += '<span class="cic th"><i class="fas fa-ring"></i> ' + jo.threads + '</span>';
            h += '</div>';

            if(!hasLane) {
                h += '<button class="load-btn" onclick="dirAddLane(\'' + jo.id + '\',\'' + q.id + '\')">';
                h += '<i class="fas fa-plus-circle"></i> Add Lane</button>';
            } else {
                h += '<button class="load-btn" style="background:#059669;" onclick="dirFocusLane(\'' + jo.id + '\')">';
                h += '<i class="fas fa-eye"></i> Focus Lane</button>';
                h += '<button class="load-btn amber" style="margin-top:4px;" onclick="dirRemoveLane(\'' + jo.id + '\')">';
                h += '<i class="fas fa-times"></i> Remove Lane</button>';
            }
            if(jo.status !== 'released') {
                h += '<button class="load-btn amber" style="margin-top:4px;" onclick="dirShowModal(\'' + jo.id + '\')">';
                h += '<i class="fas fa-hard-hat"></i> Assign</button>';
            }
            h += '</div></div>';
        });
        h += '</div></div>';
    });
    document.getElementById('dirTreeScroll').innerHTML = h;
}

function dirClickParent(qid) {
    dirTreeOpen[qid] = !dirTreeOpen[qid];
    dirRenderTree();
}

function dirClickChild(joid, qid) {
    dirTreeOpen[qid]   = true;
    dirChildOpen[joid] = !dirChildOpen[joid];
    var q  = DIR_QUOTES.find(function(x){ return x.id === qid; });
    var jo = q ? q.children.find(function(x){ return x.id === joid; }) : null;
    if(jo) {
        jo._quoteId = qid; jo._quoteName = q.name;
        dirActiveJO = jo;
        jo._laneId = DIR_LANES[joid] ? joid : null;  /* link to lane if exists */
        dirRenderInputPanel(jo);
        document.getElementById('dirActiveRef').textContent  = jo.id;
        document.getElementById('dirActiveName').textContent = jo.name;
        document.getElementById('dirActiveJOs').textContent  = q.name;
    }
    dirRenderTree();
}

function dirAddLane(joid, qid) {
    var q  = DIR_QUOTES.find(function(x){ return x.id === qid; });
    var jo = q ? q.children.find(function(x){ return x.id === joid; }) : null;
    if(!jo) return;
    jo._quoteId = qid; jo._quoteName = q.name;
    dirActiveJO = jo;

    DIR_LANES[joid] = {
        joId:      jo.id,
        joName:    jo.name,
        quoteId:   qid,
        quoteName: q.name,
        status:    jo.status,
        steps:     dirBuildSteps(jo)
    };
    if(DIR_LANE_ORD.indexOf(joid) === -1) DIR_LANE_ORD.push(joid);

    jo._laneId = joid;   /* link JO to its lane for quota tracking */
    dirRenderInputPanel(jo);
    dirRenderCanvas();
    dirRenderTree();
    dirFocusLane(joid);
    document.getElementById('dirActiveRef').textContent  = jo.id;
    document.getElementById('dirActiveName').textContent = jo.name;
    document.getElementById('dirActiveJOs').textContent  = q.name;
    dirToast(jo.id + ' lane added', '#16a34a');
}

function dirFocusLane(joid) {
    dirSelLane = joid;
    document.querySelectorAll('.swim-lane').forEach(function(el){
        el.classList.toggle('lane-focus', el.dataset.laneid === joid);
    });
    var el = document.getElementById('lane-' + joid);
    if(el) el.scrollIntoView({behavior:'smooth', block:'nearest'});
}

function dirRemoveLane(joid) {
    delete DIR_LANES[joid];
    DIR_LANE_ORD = DIR_LANE_ORD.filter(function(id){ return id !== joid; });
    if(dirSelLane === joid) dirSelLane = null;
    dirRenderCanvas();
    dirRenderTree();
    dirToast('Lane removed', '#d97706');
}

/* ════════════════════════════════
   INPUT PANEL (col 3)
   Shows items for the selected JO — drag into lane blanks
════════════════════════════════ */
function dirRenderInputPanel(jo) {
    var items  = dirBuildInputItems(jo);
    /* Count what is already placed in this JO's lane (if it exists) */
    var placed = jo._laneId ? dirCountPlaced(jo._laneId) : {};
    /* Track per-type usage so each specific item (Hole 1, Hole 2…) is matched */
    var usedCount = {};   /* type → how many already placed */
    var allPlaced = {};   /* idx → true if this item is already in the lane */
    items.forEach(function(item, idx) {
        var p = placed[item.type] || 0;
        var u = usedCount[item.type] || 0;
        if(u < p) {
            allPlaced[idx] = true;   /* this specific item is already in the lane */
            usedCount[item.type] = u + 1;
        } else {
            usedCount[item.type] = u;
        }
    });

    var h = '<div style="font-size:9px;font-weight:800;color:#1a2540;padding:4px 4px 3px;'
          + 'border-bottom:1px solid #a8b8cc;margin-bottom:4px;">'
          + jo.id + '</div>';

    var availableCount = 0;
    items.forEach(function(item, idx) {
        var used = !!allPlaced[idx];
        availableCount += used ? 0 : 1;
        if(used) {
            /* Show as greyed-out / placed — not draggable */
            h += '<div class="qi qi-used" title="Already placed in lane">';
            h += '<i class="fas fa-check" style="font-size:9px;opacity:.5;margin-right:3px;color:#16a34a;"></i>';
            h += '<span style="text-decoration:line-through;opacity:.45;">' + item.label + '</span>';
            h += '</div>';
        } else {
            /* Available — draggable */
            h += '<div class="qi" data-type="' + item.type + '" draggable="true" data-idx="' + idx + '"';
            h += ' ondragstart="dirDnItem(event,' + idx + ')">';
            h += '<i class="fas ' + item.icon + '" style="font-size:10px;pointer-events:none;"></i>' + item.label;
            h += '</div>';
        }
    });

    if(items.length === 0) {
        h += '<div style="font-size:10px;color:#9aaabb;text-align:center;padding:10px 4px;">No items</div>';
    } else if(availableCount === 0) {
        h += '<div style="font-size:10px;color:#16a34a;text-align:center;padding:8px 4px;font-weight:700;">'
          + '<i class="fas fa-check-circle"></i> All placed!</div>';
    }

    document.getElementById('dirInList').innerHTML = h;
    /* store full items list on active JO for drag lookup by index */
    dirActiveJO._inputItems = items;
}

/* ════════════════════════════════
   CANVAS — SWIM LANES
════════════════════════════════ */
function dirRenderCanvas() {
    var wrap = document.getElementById('dirFlowWrap');
    if(DIR_LANE_ORD.length === 0) {
        wrap.innerHTML = '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:220px;color:#8898aa;font-size:13px;font-weight:600;gap:12px;">'
            + '<i class="fas fa-swimming-pool" style="font-size:34px;opacity:.25;"></i>'
            + '<span>Click a Job Order in the tree then press <b>Add Lane</b></span>'
            + '</div>';
        return;
    }

    var h = '<div class="swim-pool">';
    DIR_LANE_ORD.forEach(function(joid) {
        var lane = DIR_LANES[joid];
        if(!lane) return;
        var isFocus = dirSelLane === joid;
        var stDot = lane.status==='released'?'#16a34a':lane.status==='assigned'?'#3a70c8':'#f59e0b';

        h += '<div class="swim-lane' + (isFocus?' lane-focus':'') + '"';
        h += ' id="lane-' + joid + '" data-laneid="' + joid + '">';

        /* Lane header */
        h += '<div class="lane-hd" onclick="dirFocusLane(\'' + joid + '\')">';
        h += '<div class="lane-hd-left">';
        h += '<span class="lane-dot" style="background:' + stDot + ';"></span>';
        h += '<span class="lane-jnum">' + lane.joId + '</span>';
        h += '<span class="lane-jname">' + lane.joName + '</span>';
        h += '<span class="lane-qname">\u2190 ' + lane.quoteName + '</span>';
        h += '</div>';
        h += '<div class="lane-hd-right">';
        h += '<span class="lane-status" style="color:' + stDot + ';">' + (lane.status||'pending') + '</span>';
        h += '<button class="lane-assign-btn" onclick="event.stopPropagation();dirShowModal(\'' + lane.joId + '\')"><i class="fas fa-hard-hat"></i> Assign</button>';
        h += '<button class="lane-rm-btn" onclick="event.stopPropagation();dirRemoveLane(\'' + joid + '\')"><i class="fas fa-times"></i></button>';
        h += '</div></div>';

        /* Lane steps row */
        /*
         * The lane-steps div is the DROP ZONE for the whole lane.
         * Each individual blank slot ALSO intercepts drops (stopPropagation)
         * so we know exactly which slot was targeted.
         * Start (index 0) and Ship (last) are LOCKED — no drop, no drag.
         */
        h += '<div class="lane-steps" id="lsteps-' + joid + '"';
        h += ' ondragover="dirLaneDragOver(event,\'' + joid + '\')"';
        h += ' ondragleave="dirLaneDragLeave(event,\'' + joid + '\')"';
        h += ' ondrop="dirLaneDrop(event,\'' + joid + '\')">';

        lane.steps.forEach(function(s, si) {
            var isLocked = !!s.locked;
            var isBlank  = s.type === 'blank';
            var isFirst  = si === 0;

            var shapeClass = (!isBlank && s.shape) ? (' ' + s.shape) : '';
            h += '<div';
            h += ' class="dstep ' + s.cls + shapeClass + (isFirst?' fs':'') + (isLocked?' step-locked':'') + (isBlank?' step-blank':'') + '"';
            h += ' data-si="' + si + '"';

            if(isLocked) {
                /* Locked: no drag, no drop */
                h += ' draggable="false"';
            } else if(isBlank) {
                /* Blank: is a drop target, not draggable */
                h += ' draggable="false"';
                h += ' ondragover="dirSlotOver(event,' + si + ')"';
                h += ' ondragleave="dirSlotLeave(event)"';
                h += ' ondrop="dirSlotDrop(event,\'' + joid + '\',' + si + ')"';
            } else {
                /* Filled non-locked: draggable AND droppable (swap) */
                h += ' draggable="true"';
                h += ' ondragstart="dirStepDragStart(event,\'' + joid + '\',' + si + ')"';
                h += ' ondragover="dirSlotOver(event,' + si + ')"';
                h += ' ondragleave="dirSlotLeave(event)"';
                h += ' ondrop="dirSlotDrop(event,\'' + joid + '\',' + si + ')"';
            }
            h += '>';
            /* Children have pointer-events:none so events land on the div */
            if(s.icon) h += '<i class="fas ' + s.icon + '" style="pointer-events:none;"></i>';
            if(s.label) h += '<span style="pointer-events:none;margin-left:3px;">' + s.label + '</span>';
            if(isBlank)  h += '<span style="pointer-events:none;opacity:.4;font-size:9px;letter-spacing:.5px;">drop here</span>';
            h += '</div>';
        });

        /* + Add Slot button — always at end of steps row */
        h += '<button class="lane-add-slot-btn" onclick="dirAddSlot(\'' + joid + '\')"><i class="fas fa-plus"></i> + Slot</button>';

        h += '</div>'; /* /lane-steps */
        h += '</div>'; /* /swim-lane */
    });
    h += '</div>'; /* /swim-pool */
    wrap.innerHTML = h;
}

/* ════════════════════════════════
   DRAG — SOURCES
════════════════════════════════ */

/* Drag from palette (col 1) — shape comes from STEP_DEF */
function dirDn(e, type, label, cls, icon) {
    var shape = (STEP_DEF[type] && STEP_DEF[type].shape) ? STEP_DEF[type].shape : 'ss-shape-arrow';
    DIR_DRAG = {src:'palette', type:type, label:label, cls:cls, icon:icon, shape:shape};
    e.dataTransfer.setData('text/plain', 'drag');
    e.dataTransfer.effectAllowed = 'copy';
}

/* Drag from input panel (col 3) — shape from STEP_DEF */
function dirDnItem(e, idx) {
    if(!dirActiveJO || !dirActiveJO._inputItems) return;
    var item = dirActiveJO._inputItems[idx];
    if(!item) return;
    var shape = (STEP_DEF[item.type] && STEP_DEF[item.type].shape) ? STEP_DEF[item.type].shape : 'ss-shape-arrow';
    DIR_DRAG = {src:'input', type:item.type, label:item.label, cls:item.cls, icon:item.icon, shape:shape};
    e.dataTransfer.setData('text/plain', 'drag');
    e.dataTransfer.effectAllowed = 'copy';
}

/* Drag a filled step OUT of a lane (to move) */
function dirStepDragStart(e, joid, si) {
    var lane = DIR_LANES[joid];
    if(!lane) return;
    var s = lane.steps[si];
    if(!s || s.locked || s.type === 'blank') { e.preventDefault(); return; }
    var sd = STEP_DEF[s.type] || {};
    DIR_DRAG = {src:'lane', type:s.type, label:s.label, cls:s.cls, icon:s.icon, shape:s.shape||(sd.shape||'ss-shape-arrow'), fromLane:joid, fromIdx:si};
    e.dataTransfer.setData('text/plain', 'drag');
    e.dataTransfer.effectAllowed = 'move';
    /* mark source slot visually */
    e.target.style.opacity = '0.4';
}

/* ════════════════════════════════
   DRAG — LANE ZONE (background drop)
   Fires when dropped on the lane-steps background (missed all slots)
════════════════════════════════ */
function dirLaneDragOver(e, joid) {
    /* Only accept if the drag came from palette or input */
    e.preventDefault();
    document.getElementById('lsteps-' + joid).classList.add('ldov');
}
function dirLaneDragLeave(e, joid) {
    /* Only remove highlight if leaving the container itself */
    if(e.currentTarget.contains(e.relatedTarget)) return;
    document.getElementById('lsteps-' + joid).classList.remove('ldov');
}
function dirLaneDrop(e, joid) {
    e.preventDefault();
    document.getElementById('lsteps-' + joid).classList.remove('ldov');
    if(!DIR_DRAG) return;
    /* Dropped on background — fill the first blank slot */
    var lane = DIR_LANES[joid];
    if(!lane) return;
    var blankIdx = -1;
    for(var i = 1; i < lane.steps.length - 1; i++) {
        if(lane.steps[i].type === 'blank') { blankIdx = i; break; }
    }
    if(blankIdx >= 0) {
        /* ── QUOTA CHECK ── */
        var movingSameType = (DIR_DRAG.src === 'lane' && DIR_DRAG.fromLane === joid);
        if(!dirQuotaOk(joid, DIR_DRAG.type, movingSameType ? DIR_DRAG.type : null)) {
            var quota = dirGetQuota(joid, DIR_DRAG.type);
            dirToast('Max ' + quota + ' × ' + DIR_DRAG.label.replace(/ \d+$/, '') + ' allowed in this lane', '#ef4444');
            DIR_DRAG = null;
            return;
        }
        lane.steps[blankIdx] = mkStep(DIR_DRAG.type, DIR_DRAG.label, DIR_DRAG.cls, DIR_DRAG.icon, DIR_DRAG.shape);
        /* If moving from another lane, blank that slot */
        if(DIR_DRAG.src === 'lane' && DIR_DRAG.fromLane !== joid) {
            var fl = DIR_LANES[DIR_DRAG.fromLane];
            if(fl) fl.steps[DIR_DRAG.fromIdx] = mkBlank();
        }
        DIR_DRAG = null;
        dirRenderCanvas();
        dirFocusLane(joid);
        /* refresh input panel so placed item is crossed off */
        if(dirActiveJO && dirActiveJO._laneId === joid) dirRenderInputPanel(dirActiveJO);
        dirToast('Step added to ' + joid, '#2563eb');
    } else {
        dirToast('All slots filled — drop on a specific slot to replace', '#d97706');
    }
}

/* ════════════════════════════════
   DRAG — SLOT (specific step drop)
════════════════════════════════ */
function dirSlotOver(e, si) {
    e.preventDefault();
    e.stopPropagation();
    e.currentTarget.classList.add('dov');
}
function dirSlotLeave(e) {
    e.currentTarget.classList.remove('dov');
}
function dirSlotDrop(e, joid, si) {
    e.preventDefault();
    e.stopPropagation();
    e.currentTarget.classList.remove('dov');
    document.getElementById('lsteps-' + joid).classList.remove('ldov');
    if(!DIR_DRAG) return;
    var lane = DIR_LANES[joid];
    if(!lane) return;
    var target = lane.steps[si];
    /* Never overwrite locked slots */
    if(target && target.locked) {
        dirToast('Start and Ship are locked', '#d97706');
        DIR_DRAG = null;
        return;
    }
    /* ── QUOTA CHECK ──
       replacingType = what is currently in this slot (may free up quota for same type) */
    var replacingType = (target && !target.locked && target.type !== 'blank') ? target.type : null;
    if(!dirQuotaOk(joid, DIR_DRAG.type, replacingType)) {
        var quota = dirGetQuota(joid, DIR_DRAG.type);
        dirToast('Max ' + quota + ' × ' + DIR_DRAG.label.replace(/ \d+$/, '') + ' allowed in this lane', '#ef4444');
        DIR_DRAG = null;
        return;
    }
    /* Place the step */
    lane.steps[si] = mkStep(DIR_DRAG.type, DIR_DRAG.label, DIR_DRAG.cls, DIR_DRAG.icon, DIR_DRAG.shape);
    /* If moving from another slot in same or different lane — blank the source */
    if(DIR_DRAG.src === 'lane') {
        var fl = DIR_LANES[DIR_DRAG.fromLane];
        if(fl && !(DIR_DRAG.fromLane === joid && DIR_DRAG.fromIdx === si)) {
            fl.steps[DIR_DRAG.fromIdx] = mkBlank();
        }
    }
    DIR_DRAG = null;
    /* restore opacity on all steps */
    document.querySelectorAll('.dstep').forEach(function(el){ el.style.opacity = ''; });
    dirRenderCanvas();
    dirFocusLane(joid);
    /* refresh input panel so placed item is crossed off, or restored if blanked */
    if(dirActiveJO && dirActiveJO._laneId === joid) dirRenderInputPanel(dirActiveJO);
    dirToast('Placed: ' + lane.steps[si].label, '#2563eb');
}

/* ════════════════════════════════
   TOGGLE TREE PANEL
════════════════════════════════ */
function dirToggleTree() {
    dirTreeCol = !dirTreeCol;
    document.getElementById('dirTree').classList.toggle('collapsed', dirTreeCol);
    document.getElementById('dirTreeIco').className = 'fas fa-chevron-' + (dirTreeCol?'right':'left');
}

/* ════════════════════════════════
   MODAL & TOAST
════════════════════════════════ */
function dirShowModal(ref) {
    document.getElementById('dirModalRef').textContent = ref || '\u2014';
    document.getElementById('dirModal').classList.add('on');
}
function dirCloseModal() { document.getElementById('dirModal').classList.remove('on'); }
document.getElementById('dirModal').addEventListener('click', function(e){ if(e.target===this) dirCloseModal(); });

function dirToast(msg, col) {
    var t = document.getElementById('dir-toast');
    t.style.borderLeftColor = col || '#22c55e';
    document.getElementById('dir-toast-txt').textContent = msg;
    t.classList.add('on');
    clearTimeout(t._t);
    t._t = setTimeout(function(){ t.classList.remove('on'); }, 2600);
}

/* ════════════════════════════════
   INIT
════════════════════════════════ */
dirTreeOpen['Q-000002'] = true;
dirRenderTree();
dirRenderCanvas();
</script>
@endverbatim
@endpush