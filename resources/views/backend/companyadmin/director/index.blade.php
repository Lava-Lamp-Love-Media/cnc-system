@extends('layouts.app')
@section('page-title', 'Shop Director')

@section('style')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ══════════════════════════════════════════════
   SHOP DIRECTOR — Design System
   Tone: Industrial precision / dark-dominant
   Font: DM Sans + DM Mono
══════════════════════════════════════════════ */
:root {
  --ink:       #0f1623;
  --ink2:      #1a2440;
  --ink3:      #243058;
  --ink4:      #2e3c6e;
  --rim:       rgba(255,255,255,.07);
  --rim2:      rgba(255,255,255,.13);
  --muted:     rgba(255,255,255,.38);
  --soft:      rgba(255,255,255,.65);
  --bright:    rgba(255,255,255,.92);
  --canvas-bg: #e8ecf4;
  --dot:       rgba(30,50,120,.12);

  /* Node palette */
  --start:   #16a34a;
  --stop:    #475569;
  --mach:    #1d4ed8;
  --op:      #6d28d9;
  --insp:    #c2410c;
  --hole:    #0369a1;
  --tap:     #be123c;
  --item:    #065f46;
  --inv:     #b45309;
  --pack:    #7e22ce;
  --ship:    #5b21b6;
  --rework:  #92400e;
  --ctrl:    #991b1b;
  --qual:    #0e7490;

  --gold:    #f59e0b;
  --blue:    #3b82f6;
  --green:   #22c55e;
  --red:     #ef4444;
}

html, body { height: 100%; margin: 0; font-family: 'DM Sans', sans-serif; }
* { box-sizing: border-box; }

/* Override app shell padding */
.wrapper > .content-wrapper, .content-wrapper { padding: 0 !important; margin-top: 0 !important; }
section.content { padding: 0 !important; }

/* ══ ROOT SHELL ══════════════════════════════ */
.director {
  display: grid;
  grid-template-areas:
    "topbar  topbar  topbar"
    "sidebar canvas  analysis"
    "sidebar bottom  bottom";
  grid-template-columns: 240px 1fr 270px;
  grid-template-rows: 46px 1fr 210px;
  height: calc(100vh - 57px);  /* minus admin-lte nav */
  min-height: 680px;
  background: var(--ink);
  font-family: 'DM Sans', sans-serif;
  overflow: hidden;
}

/* ══ TOPBAR ══════════════════════════════════ */
.d-topbar {
  grid-area: topbar;
  background: var(--ink);
  border-bottom: 1px solid var(--rim2);
  display: flex; align-items: center;
  padding: 0 14px; gap: 8px;
  z-index: 200;
}
.d-topbar .brand {
  display: flex; align-items: center; gap: 7px;
  font-weight: 700; font-size: 13px; color: var(--bright);
  padding-right: 14px; border-right: 1px solid var(--rim2);
  margin-right: 6px;
}
.d-topbar .brand .logo-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--gold); box-shadow: 0 0 8px var(--gold);
}
.d-topbar .job-badge {
  display: flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,.06); border: 1px solid var(--rim2);
  border-radius: 6px; padding: 3px 10px; font-size: 11px;
}
.d-topbar .job-badge .jb-num {
  font-family: 'DM Mono', monospace; font-weight: 500;
  color: var(--gold); font-size: 12px;
}
.d-topbar .job-badge .jb-label { color: var(--muted); font-size: 10px; }
.d-topbar .job-badge .jb-name  { color: var(--soft); }

.d-topbar .mode-tabs {
  display: flex; gap: 2px; margin-left: 8px;
  background: rgba(255,255,255,.05); border-radius: 7px;
  padding: 3px; border: 1px solid var(--rim);
}
.mtab {
  padding: 3px 12px; border-radius: 5px; font-size: 11px;
  font-weight: 600; color: var(--muted); cursor: pointer;
  border: none; background: transparent; transition: all .15s;
}
.mtab.active { background: var(--ink3); color: var(--bright); }
.mtab:hover:not(.active) { color: var(--soft); }

.d-topbar .spacer { flex: 1; }
.d-topbar .tb-right { display: flex; align-items: center; gap: 6px; }

.icobtn {
  width: 30px; height: 30px; border-radius: 7px;
  background: rgba(255,255,255,.06); border: 1px solid var(--rim);
  color: var(--muted); font-size: 12px; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: all .15s;
}
.icobtn:hover { background: var(--ink3); color: var(--bright); }
.icobtn.primary { background: var(--gold); color: #1a1a1a; border-color: var(--gold); font-size: 11px; width: auto; padding: 0 12px; gap: 5px; font-weight: 700; }
.icobtn.primary:hover { background: #d97706; }
.icobtn.success { background: #166534; color: #4ade80; border-color: #166534; }
.icobtn.success:hover { background: #15803d; }

/* ══ LEFT SIDEBAR ════════════════════════════ */
.d-sidebar {
  grid-area: sidebar;
  background: var(--ink2);
  border-right: 1px solid var(--rim);
  display: flex; flex-direction: column;
  overflow: hidden;
}

.sb-header {
  padding: 10px 12px 8px;
  border-bottom: 1px solid var(--rim);
  flex-shrink: 0;
}
.sb-header-title {
  font-size: 11px; font-weight: 700; color: var(--muted);
  text-transform: uppercase; letter-spacing: .8px; margin-bottom: 7px;
  display: flex; align-items: center; gap: 5px;
}
.sb-header-title i { color: var(--gold); }

.sb-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 8px; }
.sb-tag {
  font-size: 10px; padding: 2px 7px; border-radius: 10px;
  font-weight: 600; border: 1px solid; cursor: pointer;
}
.sb-tag.warn { color: #fbbf24; border-color: rgba(251,191,36,.3); background: rgba(251,191,36,.1); }
.sb-tag.blue { color: #60a5fa; border-color: rgba(96,165,250,.3); background: rgba(96,165,250,.1); }

/* 4 main add buttons */
.sb-add-btns { display: flex; flex-direction: column; gap: 5px; }
.sb-add-btn {
  display: flex; align-items: center; gap: 8px;
  padding: 7px 10px; border-radius: 8px; font-size: 12px;
  font-weight: 600; color: #fff; cursor: grab; border: 1px solid rgba(255,255,255,.15);
  user-select: none; transition: transform .12s, box-shadow .12s;
}
.sb-add-btn:hover  { transform: translateX(2px); box-shadow: 0 2px 10px rgba(0,0,0,.3); }
.sb-add-btn:active { cursor: grabbing; opacity: .75; }
.sb-add-btn .aico { width: 20px; height: 20px; border-radius: 5px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-size: 9px; flex-shrink: 0; }
.sb-add-btn.process { background: #1e40af; }
.sb-add-btn.material { background: #166534; }
.sb-add-btn.inspect  { background: #9a3412; }
.sb-add-btn.outsource { background: #6b21a8; }

/* Middle section — palette scroll */
.sb-scroll {
  flex: 1; overflow-y: auto; padding: 6px 0;
  display: flex; flex-direction: column;
}
.sb-scroll::-webkit-scrollbar { width: 3px; }
.sb-scroll::-webkit-scrollbar-thumb { background: var(--ink4); border-radius: 2px; }

.sb-section { margin-bottom: 2px; }
.sb-sec-hd {
  padding: 6px 12px 4px;
  font-size: 9px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1px; color: var(--muted);
  display: flex; align-items: center; justify-content: space-between;
  cursor: pointer;
}
.sb-sec-hd:hover { color: var(--soft); }
.sb-sec-hd i { font-size: 8px; transition: transform .2s; }
.sb-sec-hd.open i { transform: rotate(90deg); }

.sb-chips { padding: 2px 10px 6px; display: flex; flex-direction: column; gap: 4px; }
.sb-chips.hidden { display: none; }

.node-chip {
  display: flex; align-items: center; gap: 7px;
  padding: 5px 9px; border-radius: 6px; font-size: 11px;
  font-weight: 600; color: rgba(255,255,255,.88); cursor: grab;
  border: 1px solid rgba(255,255,255,.12); user-select: none;
  transition: all .12s;
}
.node-chip:hover  { transform: translateX(3px); box-shadow: 0 2px 8px rgba(0,0,0,.35); }
.node-chip:active { cursor: grabbing; opacity: .7; }
.node-chip .ci { width: 18px; height: 18px; border-radius: 4px; background: rgba(255,255,255,.18); display: flex; align-items: center; justify-content: center; font-size: 9px; flex-shrink: 0; }

/* From-quote section items */
.from-quote-item {
  display: flex; align-items: center; gap: 6px;
  padding: 4px 9px; border-radius: 5px; font-size: 10px;
  font-weight: 500; color: var(--soft); cursor: grab;
  border: 1px dashed rgba(245,158,11,.25);
  background: rgba(245,158,11,.06); margin-bottom: 3px;
  user-select: none; transition: all .12s;
}
.from-quote-item:hover { border-color: rgba(245,158,11,.6); background: rgba(245,158,11,.12); }
.from-quote-item:active { cursor: grabbing; opacity: .7; }
.from-quote-item .fqi-ico { font-size: 9px; color: var(--gold); width: 14px; }

/* ══ CANVAS ══════════════════════════════════ */
.d-canvas {
  grid-area: canvas;
  position: relative; overflow: hidden;
  background: var(--canvas-bg);
  background-image: radial-gradient(circle, var(--dot) 1.2px, transparent 1.2px);
  background-size: 22px 22px;
}

/* Canvas toolbar strip */
.canvas-tools {
  position: absolute; top: 10px; left: 50%; transform: translateX(-50%);
  background: var(--ink); border: 1px solid var(--rim2);
  border-radius: 10px; padding: 4px 8px; display: flex;
  gap: 3px; z-index: 100; box-shadow: 0 4px 20px rgba(0,0,0,.4);
}
.ct {
  width: 28px; height: 28px; border-radius: 6px; background: transparent;
  border: 1px solid transparent; color: var(--muted); font-size: 11px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; transition: all .12s;
}
.ct:hover  { background: var(--ink3); color: var(--bright); }
.ct.active { background: var(--blue); color: #fff; border-color: var(--blue); }
.ct-div { width: 1px; background: var(--rim2); margin: 5px 2px; }

/* SVG arrow layer */
#svgLayer {
  position: absolute; inset: 0; pointer-events: none; overflow: visible;
  width: 100%; height: 100%;
}

/* Node container */
#nodeLayer {
  position: absolute; inset: 0;
  transform-origin: 0 0;
}

/* ══ FLOW NODES — pill/stadium shapes ════════ */
.fnode {
  position: absolute; display: flex; align-items: center; gap: 7px;
  padding: 7px 16px; border-radius: 40px;   /* pill shape */
  font-size: 12px; font-weight: 700; color: #fff;
  cursor: grab; user-select: none;
  box-shadow: 0 2px 12px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.2);
  border: 2px solid rgba(255,255,255,.25);
  min-width: 100px; white-space: nowrap;
  transition: box-shadow .15s, border-color .15s;
  z-index: 10;
}
.fnode:hover  { box-shadow: 0 4px 20px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.2); border-color: rgba(255,255,255,.5); }
.fnode:active { cursor: grabbing; }
.fnode.sel    { border-color: #fff !important; box-shadow: 0 0 0 3px rgba(96,165,250,.5), 0 4px 16px rgba(0,0,0,.4); }

.fnode .ni { width: 20px; height: 20px; border-radius: 50%; background: rgba(255,255,255,.22); display: flex; align-items: center; justify-content: center; font-size: 9px; flex-shrink: 0; }
.fnode .nlabel { font-size: 11px; line-height: 1; }
.fnode .nsub   { font-size: 9px; opacity: .72; margin-top: 1px; }

/* node type colors */
.fn-start    { background: linear-gradient(135deg,#16a34a,#15803d); }
.fn-stop     { background: linear-gradient(135deg,#475569,#334155); }
.fn-machine  { background: linear-gradient(135deg,#1d4ed8,#1e40af); }
.fn-op       { background: linear-gradient(135deg,#7c3aed,#6d28d9); }
.fn-inspect  { background: linear-gradient(135deg,#ea580c,#c2410c); }
.fn-hole     { background: linear-gradient(135deg,#0284c7,#0369a1); }
.fn-tap      { background: linear-gradient(135deg,#e11d48,#be123c); }
.fn-item     { background: linear-gradient(135deg,#059669,#065f46); }
.fn-inv      { background: linear-gradient(135deg,#d97706,#b45309); }
.fn-ship     { background: linear-gradient(135deg,#7c3aed,#5b21b6); }
.fn-pack     { background: linear-gradient(135deg,#9333ea,#7e22ce); }
.fn-rework   { background: linear-gradient(135deg,#d97706,#92400e); }
.fn-quality  { background: linear-gradient(135deg,#0891b2,#0e7490); }
.fn-control  { background: linear-gradient(135deg,#dc2626,#991b1b); }

/* Port dots */
.fnode .port {
  position: absolute; width: 10px; height: 10px; border-radius: 50%;
  background: #fff; border: 2px solid rgba(0,0,0,.2);
  cursor: crosshair; z-index: 20; transition: transform .15s;
}
.fnode .port:hover { transform: scale(1.6) !important; }
.fnode .port-out { right: -5px; top: 50%; transform: translateY(-50%); }
.fnode .port-in  { left: -5px;  top: 50%; transform: translateY(-50%); }
.fnode .port-out:hover { transform: translateY(-50%) scale(1.6); }
.fnode .port-in:hover  { transform: translateY(-50%) scale(1.6); }

/* Node delete */
.fnode .ndel {
  position: absolute; top: -6px; right: -6px;
  width: 15px; height: 15px; border-radius: 50%;
  background: #ef4444; color: #fff; border: none;
  font-size: 7px; cursor: pointer;
  display: none; align-items: center; justify-content: center; z-index: 30;
}
.fnode:hover .ndel, .fnode.sel .ndel { display: flex; }

/* SVG arrows */
.arrow { fill: none; stroke: #94a3b8; stroke-width: 2; }
.arrow.active { stroke: var(--blue); }
@keyframes flow { to { stroke-dashoffset: -16; } }
.arrow.anim { stroke-dasharray: 5 3; animation: flow .5s linear infinite; stroke: #60a5fa; }

/* Drop zone active */
.d-canvas.drop-over {
  background-image: radial-gradient(circle, rgba(59,130,246,.25) 1.2px, transparent 1.2px);
}

/* Connect mode hint line */
#connectLine { display: none; }

/* Canvas empty state */
.canvas-empty {
  position: absolute; inset: 0; display: flex;
  flex-direction: column; align-items: center; justify-content: center;
  pointer-events: none; color: #94a3b8;
}
.canvas-empty i { font-size: 44px; margin-bottom: 12px; opacity: .4; }
.canvas-empty h5 { font-size: 15px; font-weight: 700; margin: 0 0 5px; }
.canvas-empty p  { font-size: 12px; margin: 0; opacity: .7; }

/* Zoom badge */
.zoom-badge {
  position: absolute; bottom: 10px; left: 10px;
  background: var(--ink); border: 1px solid var(--rim2);
  border-radius: 5px; padding: 3px 8px; font-size: 10px;
  font-family: 'DM Mono', monospace; font-weight: 500;
  color: var(--muted); z-index: 100;
}

/* ══ RIGHT — ANALYSIS PANEL ══════════════════ */
.d-analysis {
  grid-area: analysis;
  background: var(--ink2);
  border-left: 1px solid var(--rim);
  display: flex; flex-direction: column;
  overflow-y: auto;
}
.d-analysis::-webkit-scrollbar { width: 3px; }
.d-analysis::-webkit-scrollbar-thumb { background: var(--ink4); }

.ap-section { border-bottom: 1px solid var(--rim); }
.ap-head {
  padding: 10px 14px 6px;
  font-size: 10px; font-weight: 700; text-transform: uppercase;
  letter-spacing: .8px; color: var(--muted);
  display: flex; align-items: center; gap: 5px;
  cursor: pointer;
}
.ap-head i.sec-ico { color: var(--gold); }
.ap-head i.chev { margin-left: auto; font-size: 9px; transition: transform .2s; }
.ap-head.open i.chev { transform: rotate(180deg); }

.ap-kpi-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 7px 14px; border-bottom: 1px solid var(--rim);
}
.ap-kpi-label { font-size: 11px; color: var(--soft); }
.ap-kpi-val {
  font-family: 'DM Mono', monospace; font-size: 11px; font-weight: 500;
  padding: 2px 8px; border-radius: 4px; border: 1px solid;
}
.ap-kpi-val.green  { color: #4ade80; background: rgba(34,197,94,.12); border-color: rgba(34,197,94,.25); }
.ap-kpi-val.amber  { color: #fbbf24; background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.25); }
.ap-kpi-val.red    { color: #f87171; background: rgba(239,68,68,.12);  border-color: rgba(239,68,68,.25); }
.ap-kpi-val.blue   { color: #60a5fa; background: rgba(59,130,246,.12); border-color: rgba(59,130,246,.25); }
.ap-kpi-val.neutral{ color: var(--soft); background: rgba(255,255,255,.05); border-color: var(--rim2); }

/* Capacity bar */
.cap-section { padding: 8px 14px 10px; border-bottom: 1px solid var(--rim); }
.cap-row { display: flex; justify-content: space-between; font-size: 10px; color: var(--muted); margin-bottom: 5px; }
.cap-bar  { height: 6px; background: rgba(255,255,255,.06); border-radius: 3px; overflow: hidden; }
.cap-fill { height: 100%; border-radius: 3px; transition: width .5s, background .5s; }

/* Expandable rows */
.expand-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 8px 14px; cursor: pointer; transition: background .12s;
}
.expand-row:hover { background: rgba(255,255,255,.03); }
.expand-row .er-label { font-size: 11px; color: var(--soft); display: flex; align-items: center; gap: 6px; }
.expand-row .er-badge { font-size: 9px; padding: 1px 6px; border-radius: 10px; font-weight: 700; }
.expand-row .er-badge.warn { background: rgba(245,158,11,.2); color: #fbbf24; }
.expand-row .er-badge.ok   { background: rgba(34,197,94,.2);  color: #4ade80; }
.expand-row i.chev { font-size: 9px; color: var(--muted); transition: transform .2s; }
.expand-row.open i.chev { transform: rotate(180deg); }

.expand-body { display: none; padding: 4px 14px 10px; }
.expand-body.open { display: block; }
.expand-body .alert-item {
  display: flex; gap: 7px; padding: 5px 8px; border-radius: 6px;
  font-size: 10px; color: var(--bright); margin-bottom: 4px;
}
.alert-item.warn  { background: rgba(245,158,11,.12); border-left: 2px solid var(--gold); }
.alert-item.info  { background: rgba(59,130,246,.1);  border-left: 2px solid var(--blue); }
.alert-item.ok    { background: rgba(34,197,94,.1);   border-left: 2px solid #22c55e; }

/* Node inspector */
.node-insp { padding: 10px 14px; border-bottom: 1px solid var(--rim); display: none; }
.ni-title { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .8px; margin-bottom: 8px; display: flex; align-items: center; gap: 5px; }
.ni-title i { color: var(--blue); }
.ni-field { margin-bottom: 7px; }
.ni-field label { font-size: 10px; color: var(--muted); font-weight: 600; display: block; margin-bottom: 3px; }
.ni-field input, .ni-field select {
  width: 100%; background: rgba(255,255,255,.05);
  border: 1px solid var(--rim2); border-radius: 5px;
  color: var(--bright); font-size: 11px; padding: 4px 8px;
  font-family: 'DM Sans', sans-serif; outline: none;
}
.ni-field input:focus, .ni-field select:focus { border-color: var(--blue); background: rgba(255,255,255,.08); }
.ni-field select option { background: var(--ink2); }

/* Resource Memory button */
.res-mem-btn {
  margin: 10px 14px 12px;
  background: rgba(59,130,246,.15); border: 1px solid rgba(59,130,246,.3);
  color: #60a5fa; border-radius: 7px; padding: 8px 14px;
  font-size: 11px; font-weight: 700; cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 6px;
  transition: all .15s;
}
.res-mem-btn:hover { background: rgba(59,130,246,.25); border-color: rgba(59,130,246,.5); }

/* Progress bar in panel */
.progress-bar { height: 5px; background: rgba(255,255,255,.06); border-radius: 3px; margin: 5px 0; overflow: hidden; }
.progress-fill { height: 100%; border-radius: 3px; background: var(--blue); transition: width .5s; }

/* ══ BOTTOM PANELS ═══════════════════════════ */
.d-bottom {
  grid-area: bottom;
  display: grid; grid-template-columns: 1fr 1fr;
  background: #fff; border-top: 1px solid #dde1e9;
  overflow: hidden;
}

.bottom-panel { padding: 12px 16px; overflow-y: auto; }
.bottom-panel::-webkit-scrollbar { width: 3px; }
.bp-title {
  font-size: 11px; font-weight: 700; text-transform: uppercase;
  letter-spacing: .7px; color: #6b7280; margin-bottom: 10px;
  display: flex; align-items: center; gap: 6px;
}
.bp-title i { color: var(--blue); }

/* Scenario table */
.sc-tbl { width: 100%; border-collapse: collapse; font-size: 11px; }
.sc-tbl th {
  text-align: left; padding: 4px 8px; font-size: 10px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .5px; color: #9ca3af;
  border-bottom: 1px solid #e9ecf0;
}
.sc-tbl td { padding: 5px 8px; border-bottom: 1px solid #f1f5f9; }
.sc-tbl td:first-child { font-weight: 600; color: #374151; }
.sc-val {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 2px 8px; border-radius: 4px; font-weight: 700;
  font-family: 'DM Mono', monospace; font-size: 11px;
}
.sc-val.cur  { background: #eff6ff; color: #1d4ed8; }
.sc-val.prop { background: #f0fdf4; color: #15803d; }
.sc-val.worse { background: #fef2f2; color: #dc2626; }
.sc-val.warn  { background: #fffbeb; color: #d97706; }

.sc-delta { font-size: 9px; font-weight: 700; margin-left: 3px; }
.sc-delta.up   { color: #dc2626; }
.sc-delta.down { color: #16a34a; }

/* Approval panel */
.bp-ap { border-left: 1px solid #e9ecf0; }
.ar-field { display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 11px; }
.ar-field .arl { color: #6b7280; font-weight: 600; }
.ar-field .arv { font-weight: 700; color: #1e293b; }
.ar-field .arv.pos { color: #16a34a; }
.ar-field .arv.neg { color: #dc2626; }
.ar-field .arv.neu { color: #d97706; }

.ar-note {
  background: #f8fafc; border: 1px solid #e4e7ec; border-radius: 7px;
  padding: 7px 10px; font-size: 11px; color: #374151;
  font-style: italic; margin: 8px 0 10px;
}
.ar-btns { display: flex; gap: 6px; }
.ar-btn {
  flex: 1; padding: 7px 4px; border-radius: 6px;
  font-size: 11px; font-weight: 700; border: none; cursor: pointer;
  transition: opacity .15s; display: flex; align-items: center; justify-content: center; gap: 4px;
}
.ar-btn:hover { opacity: .85; }
.ar-btn.reject  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.ar-btn.request { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
.ar-btn.approve { background: #16a34a; color: #fff; }

/* ══ TOAST ═══════════════════════════════════ */
#dToast {
  position: fixed; bottom: 16px; right: 16px; z-index: 9999;
  background: var(--ink); color: var(--bright);
  border-left: 3px solid var(--gold);
  border-radius: 8px; padding: 9px 16px; font-size: 12px;
  font-weight: 600; box-shadow: 0 4px 24px rgba(0,0,0,.4);
  display: none; align-items: center; gap: 8px;
  font-family: 'DM Sans', sans-serif;
  animation: slideIn .2s ease;
}
#dToast.show { display: flex; }
#dToast.ok  { border-color: var(--green); }
#dToast.err { border-color: var(--red); }
@keyframes slideIn {
  from { transform: translateY(10px); opacity: 0; }
  to   { transform: translateY(0);    opacity: 1; }
}
</style>
@endsection

@section('content')
<div class="director" id="director">

{{-- ══ TOPBAR ══ --}}
<div class="d-topbar">
  <div class="brand">
    <div class="logo-dot"></div>
    {{ auth()->user()->company->name ?? 'INDUSTRY XYZ' }}
    <span style="color:var(--muted);font-weight:400;font-size:12px;">— Shop Director</span>
  </div>

  <div class="job-badge">
    <i class="fas fa-user-circle" style="color:var(--muted);font-size:11px;"></i>
    <span class="jb-label">Job</span>
    <span class="jb-num" id="topJobNum">—</span>
    <span class="jb-name" id="topJobName">No quote linked</span>
  </div>

  <div class="mode-tabs">
    <button class="mtab active" onclick="switchMode('build',this)">Build Workflow</button>
    <button class="mtab" onclick="switchMode('simulate',this)">Simulate</button>
    <button class="mtab" onclick="switchMode('compare',this)">Compare</button>
    <button class="mtab" onclick="switchMode('approve',this)">Approval</button>
  </div>

  <div class="spacer"></div>

  <div class="tb-right">
    <button class="icobtn" title="Undo (Ctrl+Z)" onclick="undoAct()"><i class="fas fa-undo"></i></button>
    <button class="icobtn" title="Redo (Ctrl+Y)" onclick="redoAct()"><i class="fas fa-redo"></i></button>
    <button class="icobtn" title="Auto Layout" onclick="autoLayout()"><i class="fas fa-magic"></i></button>
    <button class="icobtn" title="Export JSON" onclick="exportFlow()"><i class="fas fa-download"></i></button>
    <button class="icobtn success" title="Save" onclick="saveFlow()"><i class="fas fa-save"></i></button>
    <button class="icobtn primary" onclick="submitFlow()">
      <i class="fas fa-paper-plane"></i> Submit
    </button>
  </div>
</div>

{{-- ══ LEFT SIDEBAR ══ --}}
<div class="d-sidebar">

  <div class="sb-header">
    <div class="sb-header-title"><i class="fas fa-layer-group"></i> Operations Library</div>
    <div class="sb-tags">
      <span class="sb-tag warn"><i class="fas fa-exclamation-triangle" style="font-size:8px;margin-right:2px;"></i> Materials Shortages</span>
      <span class="sb-tag blue"><i class="fas fa-users" style="font-size:8px;margin-right:2px;"></i> 5 Mates</span>
    </div>
    <div class="sb-add-btns">
      <div class="sb-add-btn process"   draggable="true" data-type="machine"   data-label="Add Process">
        <span class="aico"><i class="fas fa-plus"></i></span> Add Process
      </div>
      <div class="sb-add-btn material"  draggable="true" data-type="inv"       data-label="Add Material">
        <span class="aico"><i class="fas fa-plus"></i></span> Add Material
      </div>
      <div class="sb-add-btn inspect"   draggable="true" data-type="inspect"   data-label="Add Inspection">
        <span class="aico"><i class="fas fa-plus"></i></span> Add Inspection
      </div>
      <div class="sb-add-btn outsource" draggable="true" data-type="ship"      data-label="Add Outsource">
        <span class="aico"><i class="fas fa-plus"></i></span> Add Outsource
      </div>
    </div>
  </div>

  <div class="sb-scroll">

    {{-- STRUCTURE --}}
    <div class="sb-section">
      <div class="sb-sec-hd open" onclick="togSec(this)">
        Structure <i class="fas fa-chevron-right"></i>
      </div>
      <div class="sb-chips">
        <div class="node-chip fn-start"  draggable="true" data-type="start"   data-label="Start">
          <span class="ci"><i class="fas fa-play"></i></span> Start
        </div>
        <div class="node-chip fn-stop"   draggable="true" data-type="stop"    data-label="Stop">
          <span class="ci"><i class="fas fa-stop"></i></span> Stop / End
        </div>
      </div>
    </div>

    {{-- PROCESS --}}
    <div class="sb-section">
      <div class="sb-sec-hd open" onclick="togSec(this)">
        Process <i class="fas fa-chevron-right"></i>
      </div>
      <div class="sb-chips">
        <div class="node-chip fn-machine"  draggable="true" data-type="machine"  data-label="Machine">
          <span class="ci"><i class="fas fa-cog"></i></span> Machine
        </div>
        <div class="node-chip fn-op"       draggable="true" data-type="op"       data-label="Operation">
          <span class="ci"><i class="fas fa-tools"></i></span> Operation
        </div>
        <div class="node-chip fn-inspect"  draggable="true" data-type="inspect"  data-label="Inspect">
          <span class="ci"><i class="fas fa-search"></i></span> Inspect
        </div>
        <div class="node-chip fn-rework"   draggable="true" data-type="rework"   data-label="Rework">
          <span class="ci"><i class="fas fa-redo-alt"></i></span> Rework
        </div>
        <div class="node-chip fn-quality"  draggable="true" data-type="quality"  data-label="Quality Node">
          <span class="ci"><i class="fas fa-check-circle"></i></span> Quality Node
        </div>
      </div>
    </div>

    {{-- FEATURES --}}
    <div class="sb-section">
      <div class="sb-sec-hd open" onclick="togSec(this)">
        Features <i class="fas fa-chevron-right"></i>
      </div>
      <div class="sb-chips">
        <div class="node-chip fn-hole"  draggable="true" data-type="hole"   data-label="Hole">
          <span class="ci"><i class="fas fa-circle-notch"></i></span> Hole
        </div>
        <div class="node-chip fn-tap"   draggable="true" data-type="tap"    data-label="Tap">
          <span class="ci"><i class="fas fa-screwdriver"></i></span> Tap
        </div>
        <div class="node-chip fn-item"  draggable="true" data-type="item"   data-label="Item">
          <span class="ci"><i class="fas fa-box"></i></span> Item
        </div>
      </div>
    </div>

    {{-- MATERIAL --}}
    <div class="sb-section">
      <div class="sb-sec-hd open" onclick="togSec(this)">
        Material <i class="fas fa-chevron-right"></i>
      </div>
      <div class="sb-chips">
        <div class="node-chip fn-inv"     draggable="true" data-type="inv"     data-label="Inventory">
          <span class="ci"><i class="fas fa-warehouse"></i></span> Inventory
        </div>
        <div class="node-chip fn-inv"     draggable="true" data-type="inv"     data-label="Pick Material">
          <span class="ci"><i class="fas fa-hand-paper"></i></span> Pick Material
        </div>
        <div class="node-chip fn-control" draggable="true" data-type="control" data-label="Control">
          <span class="ci"><i class="fas fa-sliders-h"></i></span> Control
        </div>
      </div>
    </div>

    {{-- OUTPUT --}}
    <div class="sb-section">
      <div class="sb-sec-hd open" onclick="togSec(this)">
        Output <i class="fas fa-chevron-right"></i>
      </div>
      <div class="sb-chips">
        <div class="node-chip fn-pack" draggable="true" data-type="pack" data-label="Pack">
          <span class="ci"><i class="fas fa-box-open"></i></span> Pack
        </div>
        <div class="node-chip fn-ship" draggable="true" data-type="ship" data-label="Ship">
          <span class="ci"><i class="fas fa-truck"></i></span> Ship
        </div>
      </div>
    </div>

    {{-- FROM QUOTE/ORDER --}}
    <div class="sb-section">
      <div class="sb-sec-hd open" onclick="togSec(this)" style="color:rgba(245,158,11,.7);">
        From Quote / Order <i class="fas fa-chevron-right"></i>
      </div>
      <div class="sb-chips" id="quoteNodeList">
        <div style="font-size:10px;color:var(--muted);padding:2px 4px;font-style:italic;">
          Link a quote to populate steps
        </div>
      </div>
    </div>

  </div>{{-- /sb-scroll --}}
</div>{{-- /sidebar --}}

{{-- ══ CANVAS ══ --}}
<div class="d-canvas" id="dCanvas">

  {{-- Toolbar --}}
  <div class="canvas-tools">
    <button class="ct active" id="ct-select"  title="Select [V]"   onclick="setTool('select')"><i class="fas fa-mouse-pointer"></i></button>
    <button class="ct"        id="ct-connect" title="Connect [C]"  onclick="setTool('connect')"><i class="fas fa-long-arrow-alt-right"></i></button>
    <button class="ct"        id="ct-pan"     title="Pan [Space]"  onclick="setTool('pan')"><i class="fas fa-hand-paper"></i></button>
    <div class="ct-div"></div>
    <button class="ct" onclick="zoomIn()"  title="Zoom In  [+]"><i class="fas fa-search-plus"></i></button>
    <button class="ct" onclick="zoomOut()" title="Zoom Out [-]"><i class="fas fa-search-minus"></i></button>
    <button class="ct" onclick="fitView()" title="Fit View [F]"><i class="fas fa-compress-arrows-alt"></i></button>
    <div class="ct-div"></div>
    <button class="ct" title="Delete selected [Del]" onclick="delSel()"><i class="fas fa-trash"></i></button>
    <button class="ct" title="Clear all" onclick="clearAll()"><i class="fas fa-times-circle"></i></button>
  </div>

  {{-- SVG arrows --}}
  <svg id="svgLayer">
    <defs>
      <marker id="ah" markerWidth="7" markerHeight="5" refX="5" refY="2.5" orient="auto">
        <polygon points="0 0,7 2.5,0 5" fill="#94a3b8"/>
      </marker>
      <marker id="ah-blue" markerWidth="7" markerHeight="5" refX="5" refY="2.5" orient="auto">
        <polygon points="0 0,7 2.5,0 5" fill="#60a5fa"/>
      </marker>
    </defs>
    <g id="arrows"></g>
    <line id="connectLine" stroke="#60a5fa" stroke-width="2" stroke-dasharray="5,3" opacity=".7"/>
  </svg>

  {{-- Nodes --}}
  <div id="nodeLayer"></div>

  {{-- Empty state --}}
  <div class="canvas-empty" id="emptyHint">
    <i class="fas fa-project-diagram"></i>
    <h5>Build Your Shop Workflow</h5>
    <p>Drag nodes from the left panel · Connect them · Analyze impact</p>
  </div>

  <div class="zoom-badge" id="zoomBadge">100%</div>
</div>

{{-- ══ RIGHT — IMPACT ANALYSIS ══ --}}
<div class="d-analysis">

  <div class="ap-section">
    <div class="ap-head open" onclick="togAp(this)">
      <i class="fas fa-chart-line sec-ico"></i>
      Impact Analysis
      <i class="fas fa-chevron-down chev"></i>
    </div>
    <div class="expand-body open">
      <div class="ap-kpi-row" style="border-bottom:1px solid var(--rim);">
        <span class="ap-kpi-label">Lead Time</span>
        <span class="ap-kpi-val green" id="kLead">$0 hr</span>
      </div>
      <div class="ap-kpi-row" style="border-bottom:1px solid var(--rim);">
        <span class="ap-kpi-label">Total Cost</span>
        <span class="ap-kpi-val amber" id="kCost">$3,550</span>
      </div>
      <div class="cap-section">
        <div class="cap-row">
          <span>Capacity Status</span>
          <span id="capText" style="color:var(--soft);">6.4 / 544</span>
        </div>
        <div class="cap-bar"><div class="cap-fill" id="capFill" style="width:1.2%;background:#22c55e;"></div></div>
      </div>
    </div>
  </div>

  {{-- Node Inspector --}}
  <div class="node-insp" id="nodeInsp">
    <div class="ni-title"><i class="fas fa-sliders-h"></i> Node Properties</div>
    <div class="ni-field">
      <label>Label</label>
      <input type="text" id="ni-label" oninput="updNode('label',this.value)">
    </div>
    <div class="ni-field">
      <label>Duration (min)</label>
      <input type="number" id="ni-dur" min="0" oninput="updNode('dur',this.value)">
    </div>
    <div class="ni-field">
      <label>Machine</label>
      <select id="ni-mach" onchange="updNode('mach',this.value)">
        <option value="">— select —</option>
        @if(isset($machines))
          @foreach($machines as $m)
            <option value="{{ $m->id }}">{{ $m->name }}</option>
          @endforeach
        @else
          <option value="1">HAAS VF-4</option>
          <option value="2">Mazak ST-20</option>
          <option value="3">DMG VMC-500</option>
        @endif
      </select>
    </div>
    <div class="ni-field">
      <label>Operator</label>
      <select id="ni-oper" onchange="updNode('oper',this.value)">
        <option value="">— select —</option>
        @if(isset($operators))
          @foreach($operators as $o)
            <option value="{{ $o->id }}">{{ $o->name }}</option>
          @endforeach
        @else
          <option>Skilled Machinist</option>
          <option>Senior Operator</option>
        @endif
      </select>
    </div>
    <div class="ni-field">
      <label>Notes</label>
      <input type="text" id="ni-notes" oninput="updNode('notes',this.value)">
    </div>
  </div>

  {{-- Alerts --}}
  <div class="expand-row open" onclick="togExpand(this)">
    <span class="er-label"><i class="fas fa-bell" style="color:var(--gold);font-size:10px;"></i> Alerts</span>
    <span class="er-badge warn" id="alertBadge">1</span>
    <i class="fas fa-chevron-down chev"></i>
  </div>
  <div class="expand-body open" id="alertsBody">
    <div class="alert-item info">
      <i class="fas fa-info-circle" style="color:#60a5fa;flex-shrink:0;margin-top:1px;font-size:10px;"></i>
      <span>Add Start &amp; Stop nodes to define your flow</span>
    </div>
  </div>

  {{-- Progress --}}
  <div class="expand-row" onclick="togExpand(this)">
    <span class="er-label"><i class="fas fa-tasks" style="color:#60a5fa;font-size:10px;"></i> Progress</span>
    <span class="er-badge ok" id="progBadge">0%</span>
    <i class="fas fa-chevron-down chev"></i>
  </div>
  <div class="expand-body" id="progBody">
    <div style="font-size:10px;color:var(--muted);margin-bottom:4px;">Flow Completeness</div>
    <div class="progress-bar"><div class="progress-fill" id="progFill" style="width:0%;"></div></div>
    <div style="font-size:10px;color:var(--muted);margin-top:6px;" id="progDetail">Build your flow to track progress</div>
  </div>

  <button class="res-mem-btn" onclick="analyzeFlow()">
    <i class="fas fa-brain"></i> Resource Memory / Analyze
  </button>

</div>{{-- /analysis --}}

{{-- ══ BOTTOM ══ --}}
<div class="d-bottom">

  {{-- Scenario Comparison --}}
  <div class="bottom-panel">
    <div class="bp-title"><i class="fas fa-balance-scale"></i> Scenario Comparison</div>
    <table class="sc-tbl">
      <thead>
        <tr>
          <th></th>
          <th colspan="2">Current Route</th>
          <th colspan="2">Proposed Route</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Lead Time</td>
          <td><span class="sc-val cur" id="sc-cl">5.2 Days</span></td>
          <td><span class="sc-val cur" id="sc-cl2">5.2 Days</span></td>
          <td><span class="sc-val warn" id="sc-pl">6.8 Days</span></td>
          <td><span class="sc-val prop" id="sc-pl2">$5.6 Days</span></td>
        </tr>
        <tr>
          <td>Total Cost</td>
          <td><span class="sc-val cur" id="sc-cc">$8,200</span></td>
          <td><span class="sc-val cur" id="sc-cc2">$8,250</span></td>
          <td><span class="sc-val worse" id="sc-pc">$9,550</span></td>
          <td><span class="sc-val worse" id="sc-pc2">$9,555</span></td>
        </tr>
        <tr>
          <td>Utilization</td>
          <td><span class="sc-val cur" id="sc-cu">76%</span></td>
          <td><span class="sc-val cur" id="sc-cu2">76%</span></td>
          <td><span class="sc-val prop" id="sc-pu">85%</span></td>
          <td><span class="sc-val prop" id="sc-pu2">85%</span></td>
        </tr>
      </tbody>
    </table>
  </div>

  {{-- Approval Review --}}
  <div class="bottom-panel bp-ap">
    <div class="bp-title"><i class="fas fa-clipboard-check"></i> Approval Review</div>
    <div class="ar-field">
      <span class="arl">Changes Made</span>
      <span class="arv" id="ar-changes">—</span>
    </div>
    <div class="ar-field">
      <span class="arl">Cost Impact</span>
      <span class="arv neu" id="ar-cost">—</span>
    </div>
    <div class="ar-field">
      <span class="arl">Lead Time Change</span>
      <span class="arv neu" id="ar-lead">—</span>
    </div>
    <div class="ar-note" id="ar-note">Build your workflow and click Analyze to generate a review.</div>
    <div class="ar-btns">
      <button class="ar-btn reject"  onclick="reviewAct('reject')"><i class="fas fa-times"></i> Reject</button>
      <button class="ar-btn request" onclick="reviewAct('request')"><i class="fas fa-comment-alt"></i> Request Changes</button>
      <button class="ar-btn approve" onclick="reviewAct('approve')"><i class="fas fa-check"></i> Approve &amp; Release</button>
    </div>
  </div>

</div>{{-- /bottom --}}
</div>{{-- /director --}}

<div id="dToast"><i id="dToastIco" class="fas fa-check"></i><span id="dToastTxt"></span></div>

@endsection

@push('scripts')
<script>
/* ══════════════════════════════════════════════
   SHOP DIRECTOR ENGINE
══════════════════════════════════════════════ */
var CSRF = '{{ csrf_token() }}';
var CFG = {
  nodes: [], arrows: [], sel: null, tool: 'select',
  zoom: 1, px: 0, py: 0, seq: 1, aseq: 1,
  connecting: null, history: [], future: [],
  dragging: false, dsx: 0, dsy: 0, dnox: 0, dnoy: 0, dnode: null
};

var nodeTypes = {
  start:   { cls:'fn-start',   ico:'fa-play',            label:'Start'        },
  stop:    { cls:'fn-stop',    ico:'fa-stop',            label:'Stop'         },
  machine: { cls:'fn-machine', ico:'fa-cog',             label:'Machine'      },
  op:      { cls:'fn-op',      ico:'fa-tools',           label:'Operation'    },
  inspect: { cls:'fn-inspect', ico:'fa-search',          label:'Inspect'      },
  hole:    { cls:'fn-hole',    ico:'fa-circle-notch',    label:'Hole'         },
  tap:     { cls:'fn-tap',     ico:'fa-screwdriver',     label:'Tap'          },
  item:    { cls:'fn-item',    ico:'fa-box',             label:'Item'         },
  inv:     { cls:'fn-inv',     ico:'fa-boxes',           label:'Inventory'    },
  ship:    { cls:'fn-ship',    ico:'fa-truck',           label:'Ship'         },
  pack:    { cls:'fn-pack',    ico:'fa-box-open',        label:'Pack'         },
  rework:  { cls:'fn-rework',  ico:'fa-redo-alt',        label:'Rework'       },
  quality: { cls:'fn-quality', ico:'fa-check-circle',    label:'Quality'      },
  control: { cls:'fn-control', ico:'fa-sliders-h',       label:'Control'      },
};

var canvas  = document.getElementById('dCanvas');
var layer   = document.getElementById('nodeLayer');
var arrows  = document.getElementById('arrows');
var hint    = document.getElementById('emptyHint');
var connLine = document.getElementById('connectLine');

/* ── Sidebar section toggle ─────────────── */
function togSec(hd) {
  hd.classList.toggle('open');
  var chips = hd.nextElementSibling;
  if (chips) chips.classList.toggle('hidden');
}
function togAp(hd) {
  hd.classList.toggle('open');
  var body = hd.nextElementSibling;
  if (body) body.classList.toggle('open');
}
function togExpand(row) {
  row.classList.toggle('open');
  var body = row.nextElementSibling;
  if (body) body.classList.toggle('open');
}

/* ── Mode switch ─────────────────────────── */
function switchMode(mode, btn) {
  document.querySelectorAll('.mtab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  toast('Mode: ' + mode, 'ok');
}

/* ── Tool selection ──────────────────────── */
function setTool(t) {
  CFG.tool = t;
  CFG.connecting = null;
  document.querySelectorAll('.ct[id^=ct]').forEach(b => b.classList.remove('active'));
  var b = document.getElementById('ct-' + t);
  if (b) b.classList.add('active');
  canvas.style.cursor = t === 'pan' ? 'grab' : t === 'connect' ? 'crosshair' : 'default';
  if (t !== 'connect') { connLine.style.display = 'none'; CFG.connecting = null; }
}

/* ── Drag chips from sidebar ─────────────── */
document.querySelectorAll('[draggable=true]').forEach(chip => {
  chip.addEventListener('dragstart', e => {
    e.dataTransfer.setData('ntype',  chip.dataset.type);
    e.dataTransfer.setData('nlabel', chip.dataset.label || '');
    e.dataTransfer.setData('ndata',  chip.dataset.extra || '');
  });
});

canvas.addEventListener('dragover',  e => { e.preventDefault(); canvas.classList.add('drop-over'); });
canvas.addEventListener('dragleave', ()  => canvas.classList.remove('drop-over'));
canvas.addEventListener('drop', e => {
  e.preventDefault();
  canvas.classList.remove('drop-over');
  var type  = e.dataTransfer.getData('ntype');
  var label = e.dataTransfer.getData('nlabel');
  if (!type) return;
  var rect = canvas.getBoundingClientRect();
  var x = (e.clientX - rect.left - CFG.px) / CFG.zoom;
  var y = (e.clientY - rect.top  - CFG.py) / CFG.zoom;
  addNode(type, label, x - 55, y - 20);
});

/* ── Add node ────────────────────────────── */
function addNode(type, label, x, y, extra) {
  pushH();
  var id = 'n' + (CFG.seq++);
  var n = { id, type, label: label || nodeTypes[type]?.label || type, x, y, dur: 30, mach: '', oper: '', notes: '' };
  Object.assign(n, extra || {});
  CFG.nodes.push(n);
  renderNode(n);
  hint.style.display = 'none';
  updateKPI(); updateAlerts(); updateProgress();
  return n;
}

/* ── Render node DOM ─────────────────────── */
function renderNode(n) {
  var cfg = nodeTypes[n.type] || nodeTypes.machine;
  var el = document.createElement('div');
  el.className = 'fnode ' + cfg.cls;
  el.id = 'fn-' + n.id;
  el.dataset.id = n.id;
  el.style.cssText = 'left:' + n.x + 'px;top:' + n.y + 'px;';
  el.innerHTML =
    '<span class="ni"><i class="fas ' + cfg.ico + '"></i></span>' +
    '<div><div class="nlabel">' + escH(n.label) + '</div>' +
    (n.dur ? '<div class="nsub">' + n.dur + ' min</div>' : '') +
    '</div>' +
    '<div class="port port-in"  data-id="' + n.id + '" data-port="in"></div>' +
    '<div class="port port-out" data-id="' + n.id + '" data-port="out"></div>' +
    '<button class="ndel" onclick="delNode(\'' + n.id + '\',event)" title="Delete"><i class="fas fa-times" style="font-size:7px;"></i></button>';

  /* Drag to move */
  el.addEventListener('mousedown', function(e) {
    if (e.target.classList.contains('port') || e.target.classList.contains('ndel') || e.target.closest('.ndel')) return;
    if (CFG.tool === 'connect') { startConnect(n.id); return; }
    CFG.dragging = true; CFG.dnode = n;
    CFG.dsx = e.clientX; CFG.dsy = e.clientY;
    CFG.dnox = n.x; CFG.dnoy = n.y;
    el.style.zIndex = 50;
    selNode(n.id);
    e.preventDefault();
  });

  /* Port: start or finish connection */
  el.querySelectorAll('.port').forEach(p => {
    p.addEventListener('mousedown', function(e) {
      e.stopPropagation();
      if (this.dataset.port === 'out') startConnect(n.id);
      else if (CFG.connecting && CFG.connecting !== n.id) finishConnect(n.id);
    });
  });

  el.addEventListener('click', function(e) {
    if (CFG.tool === 'connect') return;
    selNode(n.id);
    e.stopPropagation();
  });

  layer.appendChild(el);
}

/* ── Global mouse events ─────────────────── */
document.addEventListener('mousemove', function(e) {
  if (CFG.dragging && CFG.dnode) {
    var dx = (e.clientX - CFG.dsx) / CFG.zoom;
    var dy = (e.clientY - CFG.dsy) / CFG.zoom;
    CFG.dnode.x = Math.round(CFG.dnox + dx);
    CFG.dnode.y = Math.round(CFG.dnoy + dy);
    var el = document.getElementById('fn-' + CFG.dnode.id);
    if (el) { el.style.left = CFG.dnode.x + 'px'; el.style.top = CFG.dnode.y + 'px'; }
    redrawArrows();
  }
  if (CFG.panning) {
    CFG.px = CFG.panox + e.clientX - CFG.psx;
    CFG.py = CFG.panoy + e.clientY - CFG.psy;
    applyTx();
  }
  /* Connect mode temp line */
  if (CFG.connecting) {
    var fromEl = document.getElementById('fn-' + CFG.connecting);
    if (fromEl) {
      var fr = fromEl.getBoundingClientRect();
      var cr = canvas.getBoundingClientRect();
      connLine.style.display = 'block';
      connLine.setAttribute('x1', fr.right - cr.left);
      connLine.setAttribute('y1', fr.top + fr.height/2 - cr.top);
      connLine.setAttribute('x2', e.clientX - cr.left);
      connLine.setAttribute('y2', e.clientY - cr.top);
    }
  }
});
document.addEventListener('mouseup', function() {
  if (CFG.dragging) {
    var el = document.getElementById('fn-' + (CFG.dnode?.id));
    if (el) el.style.zIndex = 10;
    CFG.dragging = false; CFG.dnode = null;
  }
  CFG.panning = false;
  if (CFG.tool === 'pan') canvas.style.cursor = 'grab';
});

/* Canvas click — deselect */
canvas.addEventListener('mousedown', function(e) {
  if (CFG.tool === 'pan' || e.button === 1) {
    CFG.panning = true; CFG.psx = e.clientX; CFG.psy = e.clientY;
    CFG.panox = CFG.px; CFG.panoy = CFG.py;
    canvas.style.cursor = 'grabbing'; e.preventDefault();
  }
});
canvas.addEventListener('click', function(e) {
  if (e.target === canvas || e.target === layer) {
    selNode(null);
    if (CFG.connecting) { CFG.connecting = null; connLine.style.display = 'none'; }
  }
});

/* ── Connect nodes ───────────────────────── */
function startConnect(fromId) {
  CFG.connecting = fromId;
  var el = document.getElementById('fn-' + fromId);
  if (el) el.classList.add('sel');
  toast('Click another node\'s port to connect', null);
}
function finishConnect(toId) {
  if (!CFG.connecting || CFG.connecting === toId) { cancelConnect(); return; }
  var exists = CFG.arrows.find(a => a.from === CFG.connecting && a.to === toId);
  if (!exists) {
    pushH();
    CFG.arrows.push({ id: 'a' + (CFG.aseq++), from: CFG.connecting, to: toId });
    redrawArrows(); updateKPI(); updateAlerts(); updateProgress();
    toast('Nodes connected!', 'ok');
  }
  cancelConnect();
}
function cancelConnect() {
  if (CFG.connecting) {
    var el = document.getElementById('fn-' + CFG.connecting);
    if (el) el.classList.remove('sel');
  }
  CFG.connecting = null;
  connLine.style.display = 'none';
}

/* ── Select node ─────────────────────────── */
function selNode(id) {
  document.querySelectorAll('.fnode').forEach(el => el.classList.remove('sel'));
  CFG.sel = id;
  var insp = document.getElementById('nodeInsp');
  if (!id) { insp.style.display = 'none'; return; }
  var el = document.getElementById('fn-' + id);
  if (el) el.classList.add('sel');
  var n = CFG.nodes.find(n => n.id === id);
  if (!n) return;
  insp.style.display = 'block';
  document.getElementById('ni-label').value = n.label;
  document.getElementById('ni-dur').value   = n.dur || 30;
  document.getElementById('ni-notes').value = n.notes || '';
  document.getElementById('ni-mach').value  = n.mach || '';
  document.getElementById('ni-oper').value  = n.oper || '';
}
function updNode(prop, val) {
  if (!CFG.sel) return;
  var n = CFG.nodes.find(n => n.id === CFG.sel);
  if (!n) return;
  n[prop] = val;
  var el = document.getElementById('fn-' + n.id);
  if (!el) return;
  var lbl = el.querySelector('.nlabel');
  var sub = el.querySelector('.nsub');
  if (prop === 'label' && lbl) lbl.textContent = val;
  if (prop === 'dur' && sub) sub.textContent = val + ' min';
  updateKPI();
}

/* ── Delete node ─────────────────────────── */
function delNode(id, e) {
  if (e) e.stopPropagation();
  pushH();
  CFG.nodes  = CFG.nodes.filter(n => n.id !== id);
  CFG.arrows = CFG.arrows.filter(a => a.from !== id && a.to !== id);
  var el = document.getElementById('fn-' + id);
  if (el) el.remove();
  if (CFG.sel === id) selNode(null);
  redrawArrows(); updateKPI(); updateAlerts(); updateProgress();
  if (!CFG.nodes.length) hint.style.display = '';
}
function delSel() { if (CFG.sel) delNode(CFG.sel); }
function clearAll() {
  if (!CFG.nodes.length) return;
  if (!confirm('Clear entire canvas?')) return;
  pushH();
  CFG.nodes = []; CFG.arrows = []; CFG.sel = null;
  layer.innerHTML = ''; arrows.innerHTML = '';
  hint.style.display = '';
  selNode(null); updateKPI(); updateAlerts(); updateProgress();
  toast('Canvas cleared');
}

/* ── Draw SVG arrows ─────────────────────── */
function redrawArrows() {
  arrows.innerHTML = '';
  var cr = canvas.getBoundingClientRect();
  CFG.arrows.forEach(function(a) {
    var fe = document.getElementById('fn-' + a.from);
    var te = document.getElementById('fn-' + a.to);
    if (!fe || !te) return;
    var fr = fe.getBoundingClientRect();
    var tr = te.getBoundingClientRect();
    var x1 = fr.right  - cr.left;
    var y1 = fr.top + fr.height/2 - cr.top;
    var x2 = tr.left   - cr.left;
    var y2 = tr.top + tr.height/2 - cr.top;
    var dx = Math.max(40, Math.abs(x2-x1)*0.45);
    var path = document.createElementNS('http://www.w3.org/2000/svg','path');
    path.setAttribute('d','M'+x1+','+y1+' C'+(x1+dx)+','+y1+' '+(x2-dx)+','+y2+' '+x2+','+y2);
    path.setAttribute('class','arrow');
    path.setAttribute('marker-end','url(#ah)');
    arrows.appendChild(path);
  });
}
window.addEventListener('resize', () => setTimeout(redrawArrows, 100));

/* ── KPI update ──────────────────────────── */
function updateKPI() {
  var totalMin = CFG.nodes.reduce((s,n) => s+(parseInt(n.dur)||30), 0);
  var cost     = Math.round(totalMin * 2.1 + 800);
  var hrs      = (totalMin/60).toFixed(1);
  var capPct   = Math.min(100, Math.round(CFG.nodes.length * 11));
  document.getElementById('kLead').textContent = hrs + ' hrs';
  document.getElementById('kCost').textContent = '$' + cost.toLocaleString();
  document.getElementById('capText').textContent = capPct + ' / 544';
  var fill = document.getElementById('capFill');
  fill.style.width = capPct + '%';
  fill.style.background = capPct < 60 ? '#22c55e' : capPct < 85 ? '#f59e0b' : '#ef4444';
  /* scenario */
  document.getElementById('sc-pl').textContent  = (totalMin/60/8).toFixed(1) + ' days';
  document.getElementById('sc-pl2').textContent = (totalMin/60/8 * .95).toFixed(1) + ' days';
  document.getElementById('sc-pc').textContent  = '$' + cost.toLocaleString();
  document.getElementById('sc-pc2').textContent = '$' + Math.round(cost*.98).toLocaleString();
  document.getElementById('sc-pu').textContent  = capPct + '%';
  document.getElementById('sc-pu2').textContent = Math.min(100, capPct + 5) + '%';
}

function updateAlerts() {
  var hasStart = CFG.nodes.some(n => n.type === 'start');
  var hasStop  = CFG.nodes.some(n => n.type === 'stop');
  var items = [];
  if (!hasStart) items.push({ t:'warn', m:'No Start node defined' });
  if (!hasStop)  items.push({ t:'warn', m:'No Stop/End node defined' });
  if (CFG.nodes.length && !CFG.arrows.length) items.push({ t:'info', m:'Connect your nodes to define flow order' });
  if (CFG.nodes.length >= 3 && CFG.arrows.length >= 2 && hasStart && hasStop)
    items.push({ t:'ok', m:'Flow looks complete — ready to analyze' });
  if (!items.length) items.push({ t:'info', m:'Drag nodes to start building' });
  var ico = { warn:'fa-exclamation-triangle', info:'fa-info-circle', ok:'fa-check-circle' };
  var col = { warn:'var(--gold)', info:'#60a5fa', ok:'#4ade80' };
  document.getElementById('alertsBody').innerHTML = items.map(i =>
    '<div class="alert-item '+i.t+'"><i class="fas '+ico[i.t]+'" style="color:'+col[i.t]+';flex-shrink:0;font-size:10px;margin-top:1px;"></i><span>'+i.m+'</span></div>'
  ).join('');
  document.getElementById('alertBadge').textContent = items.filter(i=>i.t==='warn').length || '✓';
}

function updateProgress() {
  var score = 0;
  if (CFG.nodes.some(n=>n.type==='start'))  score += 20;
  if (CFG.nodes.some(n=>n.type==='stop'))   score += 20;
  if (CFG.arrows.length >= 1)               score += 20;
  if (CFG.nodes.length >= 3)               score += 20;
  if (CFG.nodes.length >= 5 && CFG.arrows.length >= 4) score += 20;
  document.getElementById('progFill').style.width = score + '%';
  document.getElementById('progBadge').textContent = score + '%';
  document.getElementById('progDetail').textContent =
    score < 40 ? 'Add more nodes to progress' :
    score < 80 ? 'Getting there — connect all steps' :
    'Flow complete — ready to submit!';
}

/* ── Analyze ─────────────────────────────── */
function analyzeFlow() {
  updateKPI(); updateAlerts(); updateProgress();
  var totalMin = CFG.nodes.reduce((s,n)=>s+(parseInt(n.dur)||30),0);
  var cost = Math.round(totalMin*2.1+800);
  document.getElementById('ar-changes').textContent = CFG.nodes.length + ' nodes, ' + CFG.arrows.length + ' connections';
  document.getElementById('ar-cost').textContent   = '+$' + (cost - 8200).toLocaleString();
  document.getElementById('ar-lead').textContent   = '+' + ((totalMin/60/8)-5.2).toFixed(1) + ' days';
  document.getElementById('ar-note').textContent   = CFG.nodes.length >= 3
    ? 'Ready for production — ' + CFG.nodes.length + ' operations across ' + CFG.arrows.length + ' steps. All checks passed.'
    : 'Add more operations to complete the workflow.';
  toast('Flow analyzed', 'ok');
}

/* ── Auto layout ─────────────────────────── */
function autoLayout() {
  if (!CFG.nodes.length) return;
  var roots = CFG.nodes.filter(n => !CFG.arrows.some(a => a.to === n.id));
  if (!roots.length) roots = [CFG.nodes[0]];
  var visited = {}, cols = {}, q = roots.map(n => ({n, d:0}));
  while (q.length) {
    var item = q.shift();
    if (visited[item.n.id]) continue;
    visited[item.n.id] = true;
    if (!cols[item.d]) cols[item.d] = [];
    cols[item.d].push(item.n);
    CFG.arrows.filter(a=>a.from===item.n.id).forEach(a=>{
      var nx = CFG.nodes.find(n=>n.id===a.to);
      if (nx) q.push({n:nx, d:item.d+1});
    });
  }
  CFG.nodes.filter(n=>!visited[n.id]).forEach(n=>{ cols[99]=(cols[99]||[]); cols[99].push(n); });
  Object.keys(cols).sort((a,b)=>+a-+b).forEach(function(col, ci) {
    cols[col].forEach(function(n, ri) {
      n.x = 60 + ci * 165; n.y = 60 + ri * 80;
      var el = document.getElementById('fn-'+n.id);
      if (el) { el.style.left=n.x+'px'; el.style.top=n.y+'px'; }
    });
  });
  setTimeout(redrawArrows,50); toast('Layout applied','ok');
}

/* ── Zoom / Pan ──────────────────────────── */
function applyTx() {
  layer.style.transform = 'translate('+CFG.px+'px,'+CFG.py+'px) scale('+CFG.zoom+')';
  layer.style.transformOrigin = '0 0';
  document.getElementById('zoomBadge').textContent = Math.round(CFG.zoom*100)+'%';
  setTimeout(redrawArrows,20);
}
function zoomIn()  { CFG.zoom = Math.min(2.5, CFG.zoom+.1); applyTx(); }
function zoomOut() { CFG.zoom = Math.max(.25, CFG.zoom-.1); applyTx(); }
function fitView() { CFG.zoom=1; CFG.px=0; CFG.py=0; applyTx(); }

canvas.addEventListener('wheel', function(e) {
  e.preventDefault();
  CFG.zoom = Math.min(2.5, Math.max(.25, CFG.zoom + (e.deltaY<0?.1:-.1)));
  applyTx();
}, { passive: false });

/* ── Undo / Redo ─────────────────────────── */
function pushH() {
  CFG.history.push(JSON.stringify({nodes:CFG.nodes, arrows:CFG.arrows, seq:CFG.seq, aseq:CFG.aseq}));
  CFG.future = [];
}
function undoAct() {
  if (!CFG.history.length) return;
  CFG.future.push(JSON.stringify({nodes:CFG.nodes, arrows:CFG.arrows}));
  var s = JSON.parse(CFG.history.pop());
  Object.assign(CFG, s); rebuild();
}
function redoAct() {
  if (!CFG.future.length) return;
  CFG.history.push(JSON.stringify({nodes:CFG.nodes, arrows:CFG.arrows}));
  var s = JSON.parse(CFG.future.pop());
  Object.assign(CFG, s); rebuild();
}
function rebuild() {
  layer.innerHTML=''; arrows.innerHTML='';
  CFG.nodes.forEach(renderNode);
  setTimeout(redrawArrows,50);
  updateKPI(); updateAlerts(); updateProgress();
  if (!CFG.nodes.length) hint.style.display='';
}

/* ── Save / Export ───────────────────────── */
function saveFlow() {
  var data = { nodes: CFG.nodes, arrows: CFG.arrows };
  // POST to server: /company/shop-director/save
  console.log('Flow:', data);
  toast('Workflow saved!', 'ok');
}
function exportFlow() {
  var b = new Blob([JSON.stringify({nodes:CFG.nodes,arrows:CFG.arrows},null,2)],{type:'application/json'});
  var a = document.createElement('a'); a.href=URL.createObjectURL(b); a.download='workflow.json'; a.click();
  toast('Exported', 'ok');
}
function submitFlow() { analyzeFlow(); toast('Submitted for approval!', 'ok'); }
function reviewAct(a) {
  var m = {reject:'Workflow rejected',request:'Changes requested',approve:'Approved & Released!'};
  toast(m[a], a==='approve'?'ok':null);
}

/* ── Keyboard shortcuts ──────────────────── */
document.addEventListener('keydown', function(e) {
  if (['INPUT','SELECT','TEXTAREA'].includes(e.target.tagName)) return;
  if (e.key==='v'||e.key==='V') setTool('select');
  if (e.key==='c'||e.key==='C') setTool('connect');
  if (e.key===' ') { e.preventDefault(); setTool('pan'); }
  if (e.key==='f'||e.key==='F') fitView();
  if ((e.key==='+'||e.key==='=')) zoomIn();
  if (e.key==='-') zoomOut();
  if (e.key==='Delete') delSel();
  if (e.ctrlKey&&e.key==='z') { e.preventDefault(); undoAct(); }
  if (e.ctrlKey&&e.key==='y') { e.preventDefault(); redoAct(); }
});

/* ── Toast ───────────────────────────────── */
function toast(msg, type) {
  var t = document.getElementById('dToast');
  var i = document.getElementById('dToastIco');
  t.className = 'show' + (type?' '+type:'');
  i.className = 'fas ' + (type==='ok'?'fa-check':type==='err'?'fa-times':'fa-info-circle');
  document.getElementById('dToastTxt').textContent = msg;
  clearTimeout(t._t); t._t = setTimeout(()=>t.className='', 2600);
}

/* ── HTML escape ─────────────────────────── */
function escH(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

/* ── Demo workflow on load ───────────────── */
function loadDemo() {
  var defs = [
    { type:'start',   label:'Start',         x:50,  y:140 },
    { type:'inv',     label:'Inventory',      x:220, y:140 },
    { type:'inv',     label:'Pick Material',  x:390, y:140 },
    { type:'machine', label:'CNC Turn',       x:560, y:80,  dur:45 },
    { type:'hole',    label:'Drill Holes',    x:560, y:190, dur:20 },
    { type:'tap',     label:'Tap M6×1.0',     x:730, y:190, dur:15 },
    { type:'inspect', label:'CMM Inspect',    x:730, y:80,  dur:30 },
    { type:'pack',    label:'Pack',           x:900, y:140 },
    { type:'stop',    label:'Stop',           x:1060,y:140 },
  ];
  var ids = defs.map(d => addNode(d.type, d.label, d.x, d.y, d.dur ? {dur:d.dur} : {}));
  setTimeout(function() {
    [[0,1],[1,2],[2,3],[2,4],[3,6],[4,5],[5,6],[6,7],[7,8]].forEach(p => {
      CFG.arrows.push({id:'a'+(CFG.aseq++), from:ids[p[0]].id, to:ids[p[1]].id});
    });
    redrawArrows(); updateKPI(); updateAlerts(); updateProgress();
  }, 150);
}

document.addEventListener('DOMContentLoaded', function() {
  setTimeout(loadDemo, 200);
});
</script>
@endpush