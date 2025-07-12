// resources/js/heatmap-init.js
document.addEventListener("DOMContentLoaded", () => {
  if (!window.heatmapData || !window.heatmapStart) return;     // guard

  const formatted = {};
  Object.entries(window.heatmapData).forEach(([date, val]) => {
    const ts = Date.parse(date);
    if (!isNaN(ts)) formatted[Math.floor(ts / 1000)] = val;
  });

  new CalHeatMap().init({
    itemSelector: "#heatmap",
    domain: "month",
    subDomain: "day",
    range: 12, // tampilkan 12 bulan
    cellSize: 20,
    domainGutter: 10,
    data: formatted,
    start: new Date(new Date().getFullYear(), 0, 1), // mulai dari 1 Jan tahun ini
    legend: [3600, 7200, 10800, 14400],
    legendColors: { min: "#e0f2fe", max: "#0284c7", empty: "#f3f4f6" },
    displayLegend: true,
    tooltip: true,
  });
  
});
