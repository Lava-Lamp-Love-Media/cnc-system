@extends('layouts.app')

@section('title', 'Shop Director')
@section('page-title', 'Shop Director')

@section('style')
<style>
/* ── Override AdminLTE body padding so director fills full height ── */
body.director-page .content-wrapper {
    padding: 0 !important;
    margin: 0 !important;
    height: calc(100vh - 57px);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
body.director-page .content-header { display: none; }
body.director-page .main-footer    { display: none; }

/* ── Director sub-header bar ── */
.dir-topbar {
    background: #ccd6e8;
    border-bottom: 2px solid #a8b8cc;
    height: 36px;
    display: flex;
    align-items: center;
    padding: 0 10px;
    gap: 6px;
    flex-shrink: 0;
}
.dir-topbar .dt-title {
    font-size: 12px;
    font-weight: 700;
    color: #1a2540;
    flex: 1;
    text-align: center;
}
.dtbtn {
    padding: 3px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    border: 1px solid #8a98b0;
    cursor: pointer;
    background: #d0daea;
    color: #1a2540;
    font-family: 'DM Sans', sans-serif;
    transition: background .1s;
    white-space: nowrap;
}
.dtbtn:hover   { background: #b8c8d8; }
.dtbtn.green   { background: #4a9c6a; color: #fff; border-color: #3a8458; }
.dtbtn.blue    { background: #3a70c8; color: #fff; border-color: #2a5aaa; }

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
.dp-cg  { display: grid; grid-template-columns: 1fr 1fr; gap: 3px; margin-bottom: 3px; }
.dp-cb  { padding: 4px 4px; border-radius: 4px; font-size: 10px; font-weight: 700; border: 1px solid #90a4b8; background: #c0d0e0; color: #1a2540; cursor: pointer; text-align: center; font-family: 'DM Sans', sans-serif; transition: background .1s; }
.dp-cb:hover     { background: #a8bcd0; }
.dp-cb.dg        { background: #58aa72; color: #fff; border-color: #469a60; }
.dp-cb.full      { grid-column: 1/-1; background: #58aa72; color: #fff; border-color: #469a60; }
.dp-divider      { height: 1px; background: #90a4b8; margin: 5px 2px; }

.dpn { display: flex; align-items: center; gap: 5px; padding: 5px 10px; border-radius: 18px; font-size: 11px; font-weight: 700; cursor: grab; border: 2px solid rgba(0,0,0,.2); box-shadow: 0 1px 3px rgba(0,0,0,.18); margin-bottom: 3px; user-select: none; transition: filter .1s, transform .1s; }
.dpn:hover   { filter: brightness(.88); transform: translateX(2px); }
.dpn:active  { cursor: grabbing; }
.dpn i       { font-size: 9px; opacity: .8; }
.dpn-row     { display: flex; gap: 3px; margin-bottom: 3px; }
.dpn-row .dpn { flex: 1; margin-bottom: 0; padding: 5px 4px; justify-content: center; }

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

/* ══ COL 3 — QUOTE INPUT ══ */
.dir-in {
    width: 100px;
    flex-shrink: 0;
    background: #c0ccd8;
    border-right: 2px solid #a8b8cc;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.di-hd { background: #8898b0; border-bottom: 1px solid #7888a0; padding: 5px 6px; font-size: 9px; font-weight: 700; color: #0a1828; text-align: center; line-height: 1.4; flex-shrink: 0; }
.di-list { overflow-y: auto; flex: 1; padding: 4px; }
.di-list::-webkit-scrollbar { width: 3px; }
.di-list::-webkit-scrollbar-thumb { background: #9aaabe; border-radius: 2px; }
.qi { padding: 5px 6px; border-radius: 4px; font-size: 11px; font-weight: 600; background: #fff; border: 1px solid #a8b8cc; margin-bottom: 4px; cursor: grab; text-align: center; color: #1a2540; box-shadow: 0 1px 2px rgba(0,0,0,.1); user-select: none; transition: all .1s; }
.qi:hover { background: #ddeeff; border-color: #5888cc; }
.qi:active { cursor: grabbing; opacity: .7; }

/* ══ COL 4 — FLOW CANVAS ══ */
.dir-cv {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #dce4f0;
}
.dc-hd { background: #b0bece; border-bottom: 2px solid #98aabf; padding: 4px 12px; display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
.dc-hd .dc-fl { font-size: 12px; font-weight: 700; color: #3a5070; flex: 1; text-align: center; }
.dc-qref { font-family: 'DM Mono', monospace; font-size: 11px; color: #c07000; background: #fff8e0; border: 1px solid #ddb820; border-radius: 4px; padding: 1px 7px; }
.dc-body { flex: 1; overflow: auto; padding: 14px 14px 20px; }
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
    min-width: max-content;
    padding-bottom: 20px;
}

/* Each swim lane */
.swim-lane {
    border: 2px solid #c0ccd8;
    border-radius: 0;
    background: #e8f0f8;
    border-bottom: none;
    transition: background .15s, border-color .15s;
    min-width: max-content;
}
.swim-lane:first-child { border-radius: 8px 8px 0 0; }
.swim-lane:last-child  { border-radius: 0 0 8px 8px; border-bottom: 2px solid #c0ccd8; }
.swim-lane:only-child  { border-radius: 8px; border-bottom: 2px solid #c0ccd8; }
.swim-lane.lane-focus  { background: #f0f6ff; border-color: #3a70c8; z-index: 1; position: relative; box-shadow: 0 0 0 2px rgba(58,112,200,.18); }

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

/* Lane steps row */
.lane-steps {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    gap: 0;
    overflow-x: auto;
    min-height: 66px;
    flex-wrap: nowrap;
}
.lane-steps::-webkit-scrollbar { height: 4px; }
.lane-steps::-webkit-scrollbar-thumb { background: #a0b0c4; border-radius: 2px; }
.lane-steps.ldov { background: rgba(58,112,200,.08); }

/* Add slot (last blank) */
.dstep.add-slot {
    min-width: 44px; opacity: .6;
    display: flex; align-items: center; justify-content: center;
}
.dstep.add-slot:hover { opacity: 1; background: #c8d8f8; }
.dstep.last-step { }

/* Empty state */
.canvas-empty {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; height: 220px;
    color: #8898aa; font-size: 13px; font-weight: 600; gap: 12px;
}

/* Override dstep to fit lanes */
.lane-steps .dstep {
    height: 40px;
    min-width: 70px;
    font-size: 10px;
}
.lane-steps .dstep span { white-space: nowrap; pointer-events: none; }

/* Locked step (Start/Ship) — no drop cursor */
.dstep.step-locked { cursor: default; opacity: .95; }
.dstep.step-locked:hover { filter: none; transform: none; }

/* Blank drop slot — clearly a target */
.dstep.step-blank {
    background: repeating-linear-gradient(
        -45deg,
        #dce8f8,
        #dce8f8 4px,
        #e8f0fc 4px,
        #e8f0fc 12px
    ) !important;
    color: #90a8c8;
    border: 2px dashed #90a8c8 !important;
    min-width: 80px;
    opacity: .7;
}
.dstep.step-blank:hover { opacity: 1; border-color: #3a70c8 !important; background: #dbeafe !important; }
.dstep.step-blank.dov   { opacity: 1; border-color: #3a70c8 !important; background: #bfdbfe !important; border-style: solid !important; }


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

{{-- Director Sub-Header --}}
<div class="dir-topbar mt-5">
    <a href="{{ route('company.director.index') }}" class="dtbtn">← Back</a>
    <div class="dt-title">The Director Main Screen — Parent or Child Item #</div>
    <button class="dtbtn">Save Draft</button>
    <button class="dtbtn blue">Preview</button>
    <button class="dtbtn green" onclick="dirShowModal(null)">▶ Release to Shop Floor</button>
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
        <button class="dp-cb full" style="width:100%;margin-bottom:5px;">PROCESS GREEN</button>

        <div class="dpn-row">
            <div class="dpn n-op"  draggable="true" ondragstart="dirDn(event,'op','Operation','ss-op','fa-tools')"><i class="fas fa-tools"></i>Operation</div>
            <div class="dpn n-ins" draggable="true" ondragstart="dirDn(event,'inspect','Inspect','ss-inspect','fa-search')"><i class="fas fa-search"></i>Inspect</div>
        </div>
        <div class="dpn-row">
            <div class="dpn n-cal" draggable="true" ondragstart="dirDn(event,'cal','Calibrate','ss-op','fa-sliders-h')"><i class="fas fa-sliders-h"></i>Calibrate</div>
            <div class="dpn n-asm" draggable="true" ondragstart="dirDn(event,'asm','Assemble','ss-op','fa-puzzle-piece')"><i class="fas fa-puzzle-piece"></i>Assemble</div>
        </div>
        <div class="dpn n-rwk" draggable="true" ondragstart="dirDn(event,'rework','Rework','ss-op','fa-redo')"><i class="fas fa-redo"></i>Rework</div>
        <div class="dpn n-mat" style="justify-content:center;" draggable="true" ondragstart="dirDn(event,'material','MATERIAL ABER','ss-item','fa-cube')">MATERIAL ABER</div>
        <div class="dpn-row">
            <div class="dpn n-inv" draggable="true" ondragstart="dirDn(event,'inventory','Inventory','ss-inv','fa-boxes')"><i class="fas fa-boxes"></i>Inventory</div>
            <div class="dpn n-sb1" draggable="true" ondragstart="dirDn(event,'sub','Substitute','ss-inv','fa-exchange-alt')">Substitute</div>
        </div>
        <div class="dpn-row">
            <div class="dpn n-sb2" draggable="true" ondragstart="dirDn(event,'sub','Substitute','ss-machine','fa-exchange-alt')">Substitute</div>
            <div class="dpn n-trc" draggable="true" ondragstart="dirDn(event,'trace','Trace','ss-op','fa-route')"><i class="fas fa-route"></i>Trace</div>
        </div>
        <div class="dp-divider"></div>
        <div class="dpn n-ctl" style="justify-content:center;" draggable="true" ondragstart="dirDn(event,'control','Control (Red)','ss-stop','fa-stop-circle')">Control (Red)</div>
        <div class="dpn-row">
            <div class="dpn n-hld" draggable="true" ondragstart="dirDn(event,'hold','Hold','ss-stop','fa-pause')"><i class="fas fa-pause"></i>Hold</div>
            <div class="dpn n-pri" draggable="true" ondragstart="dirDn(event,'priority','Priority','ss-stop','fa-flag')"><i class="fas fa-flag"></i>Priority</div>
        </div>
        <div class="dpn-row">
            <div class="dpn n-cap" draggable="true" ondragstart="dirDn(event,'capacity','Capacity','ss-machine','fa-chart-bar')"><i class="fas fa-chart-bar"></i>Capacity</div>
            <div class="dpn n-sim" draggable="true" ondragstart="dirDn(event,'simulate','Simulate','ss-op','fa-play')"><i class="fas fa-play"></i>Simulate</div>
        </div>
        <div class="dp-divider"></div>
        <div class="dpn n-qnv" style="justify-content:center;">
            <i class="fas fa-star"></i>&nbsp;Quality Nav
            <span style="margin-left:5px;width:13px;height:13px;background:#5888d0;border-radius:3px;display:inline-block;"></span>
        </div>
        <div class="dpn-row">
            <div class="dpn n-apr" draggable="true" ondragstart="dirDn(event,'approve','Approve','ss-approve','fa-check')"><i class="fas fa-check"></i>Approve</div>
            <div class="dpn n-fst" draggable="true" ondragstart="dirDn(event,'firstart','1st Article','ss-approve','fa-file-alt')"><i class="fas fa-file-alt"></i>1st Article</div>
        </div>
        <div class="dpn n-crt" style="border-radius:6px;justify-content:center;" draggable="true" ondragstart="dirDn(event,'cert','Cert Required','ss-approve','fa-certificate')">
            <i class="fas fa-certificate"></i>&nbsp;Cert Required
        </div>
        <div class="dp-divider"></div>
        <div class="dpn n-out" style="justify-content:center;margin-bottom:4px;">Output Purple</div>
        <div class="dpn-row">
            <div class="dpn n-pck" draggable="true" ondragstart="dirDn(event,'pack','Pack','ss-pack','fa-box-open')"><i class="fas fa-box-open"></i>Pack</div>
            <div class="dpn n-shp" draggable="true" ondragstart="dirDn(event,'ship','Ship','ss-ship','fa-truck')"><i class="fas fa-truck"></i>Ship</div>
        </div>
        <div style="height:6px;"></div>
        <div style="font-size:8px;color:#5a7090;text-align:center;border-top:1px solid #90a4b8;padding-top:5px;line-height:1.4;">info from the Quote form/Order Input</div>
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
var STEP_DEF = {
    start:    {cls:'ss-start',   icon:'fa-play',         label:'Start'},
    hole:     {cls:'ss-hole',    icon:'fa-circle-notch', label:'Hole'},
    tap:      {cls:'ss-tap',     icon:'fa-screwdriver',  label:'Tap'},
    machine:  {cls:'ss-machine', icon:'fa-cog',          label:'Machine'},
    op:       {cls:'ss-op',      icon:'fa-tools',        label:'Operation'},
    thread:   {cls:'ss-thread',  icon:'fa-ring',         label:'Thread'},
    item:     {cls:'ss-item',    icon:'fa-box',          label:'Item'},
    inventory:{cls:'ss-inv',     icon:'fa-boxes',        label:'Inventory'},
    plating:  {cls:'ss-plating', icon:'fa-paint-brush',  label:'Plating'},
    heat:     {cls:'ss-heat',    icon:'fa-fire',         label:'Heat Treat'},
    inspect:  {cls:'ss-inspect', icon:'fa-search',       label:'Inspect'},
    approve:  {cls:'ss-approve', icon:'fa-check',        label:'Approve'},
    pack:     {cls:'ss-pack',    icon:'fa-box-open',     label:'Pack'},
    ship:     {cls:'ss-ship',    icon:'fa-truck',        label:'Ship'},
    cert:     {cls:'ss-approve', icon:'fa-certificate',  label:'Cert'},
    control:  {cls:'ss-stop',    icon:'fa-stop-circle',  label:'Control'},
    hold:     {cls:'ss-stop',    icon:'fa-pause',        label:'Hold'}
};

/* Make a locked step object */
function mkLocked(type) {
    var d = STEP_DEF[type] || {cls:'ss-start', icon:'fa-play', label:type};
    return {type:type, label:d.label, cls:d.cls, icon:d.icon, locked:true};
}

/* Make a blank slot */
function mkBlank() {
    return {type:'blank', label:'', cls:'ss-blank', icon:'', locked:false};
}

/* Make a step from a palette/input drag item */
function mkStep(type, label, cls, icon) {
    return {type:type, label:label, cls:cls, icon:icon, locked:false};
}

/* ════════════════════════════════
   BUILD LANE STEPS
   START (locked) + N blank slots (one per JO item) + SHIP (locked)
   User drags items from col-3 into the blank slots.
════════════════════════════════ */
function dirBuildSteps(jo) {
    var steps = [];
    /* LOCKED first: Start */
    steps.push(mkLocked('start') );
    /* One blank slot for each item in this JO */
    var n = jo.holes + jo.taps + jo.machines + jo.ops + jo.threads + jo.items;
    if(n < 1) n = 3;
    for(var i = 0; i < n; i++) steps.push(mkBlank());
    /* LOCKED last: Ship */
    steps.push(mkLocked('ship'));
    return steps;
}

/* ════════════════════════════════
   BUILD INPUT PANEL ITEMS
   Shown in col-3, one per JO item — drag these into the lane blanks
════════════════════════════════ */
function dirBuildInputItems(jo) {
    var items = [];
    var i;
    for(i=0;i<jo.holes;i++)    items.push({type:'hole',    label:'Hole '+(i+1),     icon:'fa-circle-notch', cls:'ss-hole'});
    for(i=0;i<jo.taps;i++)     items.push({type:'tap',     label:'Tap '+(i+1),      icon:'fa-screwdriver',  cls:'ss-tap'});
    for(i=0;i<jo.machines;i++) items.push({type:'machine', label:'Machine '+(i+1),  icon:'fa-cog',          cls:'ss-machine'});
    for(i=0;i<jo.ops;i++)      items.push({type:'op',      label:'Op '+(i+1),       icon:'fa-tools',        cls:'ss-op'});
    for(i=0;i<jo.threads;i++)  items.push({type:'thread',  label:'Thread '+(i+1),   icon:'fa-ring',         cls:'ss-thread'});
    for(i=0;i<jo.items;i++)    items.push({type:'item',    label:'Item '+(i+1),      icon:'fa-box',          cls:'ss-item'});
    return items;
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
    var items = dirBuildInputItems(jo);
    var h = '<div style="font-size:9px;font-weight:800;color:#1a2540;padding:4px 4px 3px;border-bottom:1px solid #a8b8cc;margin-bottom:4px;">'
          + jo.id + '</div>';
    items.forEach(function(item, idx) {
        /* Store item index so drag carries the right data */
        h += '<div class="qi" draggable="true" data-idx="' + idx + '"';
        h += ' ondragstart="dirDnItem(event,' + idx + ')">';
        h += '<i class="fas ' + item.icon + '" style="font-size:9px;opacity:.7;margin-right:3px;"></i>' + item.label;
        h += '</div>';
    });
    if(items.length === 0) h += '<div style="font-size:10px;color:#9aaabb;text-align:center;padding:10px 4px;">No items</div>';
    document.getElementById('dirInList').innerHTML = h;
    /* store items on active JO for drag lookup */
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

            h += '<div';
            h += ' class="dstep ' + s.cls + (isFirst?' fs':'') + (isLocked?' step-locked':'') + (isBlank?' step-blank':'') + '"';
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
            if(isBlank)  h += '<span style="pointer-events:none;opacity:.35;font-size:9px;">drop</span>';
            h += '</div>';
        });

        h += '</div>'; /* /lane-steps */
        h += '</div>'; /* /swim-lane */
    });
    h += '</div>'; /* /swim-pool */
    wrap.innerHTML = h;
}

/* ════════════════════════════════
   DRAG — SOURCES
════════════════════════════════ */

/* Drag from palette (col 1) */
function dirDn(e, type, label, cls, icon) {
    DIR_DRAG = {src:'palette', type:type, label:label, cls:cls, icon:icon};
    e.dataTransfer.setData('text/plain', 'drag');
    e.dataTransfer.effectAllowed = 'copy';
}

/* Drag from input panel (col 3) — use stored index */
function dirDnItem(e, idx) {
    if(!dirActiveJO || !dirActiveJO._inputItems) return;
    var item = dirActiveJO._inputItems[idx];
    if(!item) return;
    DIR_DRAG = {src:'input', type:item.type, label:item.label, cls:item.cls, icon:item.icon};
    e.dataTransfer.setData('text/plain', 'drag');
    e.dataTransfer.effectAllowed = 'copy';
}

/* Drag a filled step OUT of a lane (to move) */
function dirStepDragStart(e, joid, si) {
    var lane = DIR_LANES[joid];
    if(!lane) return;
    var s = lane.steps[si];
    if(!s || s.locked || s.type === 'blank') { e.preventDefault(); return; }
    DIR_DRAG = {src:'lane', type:s.type, label:s.label, cls:s.cls, icon:s.icon, fromLane:joid, fromIdx:si};
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
        lane.steps[blankIdx] = mkStep(DIR_DRAG.type, DIR_DRAG.label, DIR_DRAG.cls, DIR_DRAG.icon);
        /* If moving from another lane, blank that slot */
        if(DIR_DRAG.src === 'lane' && DIR_DRAG.fromLane !== joid) {
            var fl = DIR_LANES[DIR_DRAG.fromLane];
            if(fl) fl.steps[DIR_DRAG.fromIdx] = mkBlank();
        }
        DIR_DRAG = null;
        dirRenderCanvas();
        dirFocusLane(joid);
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
    /* Place the step */
    lane.steps[si] = mkStep(DIR_DRAG.type, DIR_DRAG.label, DIR_DRAG.cls, DIR_DRAG.icon);
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