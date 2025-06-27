const format = s => {
  const h = String(Math.floor(s / 3600)).padStart(2, '0')
  const m = String(Math.floor((s % 3600) / 60)).padStart(2, '0')
  const s2 = String(s % 60).padStart(2, '0')
  return `${h}:${m}:${s2}`
}

export default () => {
  // kalau ada project aktif, main timer ikut jalan
  const hasActive = () => !!document.querySelector('[data-active="true"]')

  document.querySelectorAll('[data-timer]').forEach(el => {
    let secs = parseInt(el.dataset.seconds || 0, 10)

    // timer proyek jalan jika data-active="true"
    // timer utama jalan bila ada project aktif
    const shouldRun = el.dataset.active === 'true' || el.id === 'main-timer'

    if (shouldRun) {
      setInterval(() => {
        // untuk main timer cek lagi setiap tick
        if (el.id === 'main-timer' && !hasActive()) return
        el.textContent = format(++secs)
      }, 1000)
    }
  })
}
