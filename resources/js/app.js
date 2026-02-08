import './bootstrap';
import 'bootstrap';
import Chart from 'chart.js/auto';

const STORAGE = {
  theme: 'ape_theme',
  dir: 'ape_dir',
};

let charts = {};

const setTheme = (theme) => {
  document.documentElement.setAttribute('data-theme', theme);
  const themeToggle = document.getElementById('themeToggle');
  if (themeToggle) {
    const icon = themeToggle.querySelector('i');
    const label = themeToggle.querySelector('span');
    if (theme === 'dark') {
      icon.className = 'bi bi-brightness-high';
      label.textContent = 'Light';
    } else {
      icon.className = 'bi bi-moon-stars';
      label.textContent = 'Dark';
    }
  }
};

const setDirection = (dir) => {
  document.documentElement.setAttribute('dir', dir);
  const rtlButton = document.getElementById('rtlToggle');
  const ltrCss = document.getElementById('bootstrapLtr');
  const rtlCss = document.getElementById('bootstrapRtl');
  if (rtlButton) rtlButton.textContent = dir === 'rtl' ? 'LTR' : 'RTL';
  if (ltrCss && rtlCss) {
    if (dir === 'rtl') {
      ltrCss.disabled = true;
      rtlCss.disabled = false;
    } else {
      ltrCss.disabled = false;
      rtlCss.disabled = true;
    }
  }
};

const initReveal = () => {
  const elements = document.querySelectorAll('[data-reveal]');
  if (!('IntersectionObserver' in window)) {
    elements.forEach((el) => el.classList.add('reveal-visible'));
    return;
  }
  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('reveal-visible');
          obs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );
  elements.forEach((el) => observer.observe(el));
};

const initRefreshTime = () => {
  const refreshEl = document.getElementById('refreshTime');
  if (!refreshEl) return;
  const now = new Date();
  refreshEl.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};

const destroyCharts = () => {
  Object.values(charts).forEach((chart) => chart?.destroy());
  charts = {};
};

const buildCharts = (stats) => {
  destroyCharts();
  if (!stats) return;

  const styles = getComputedStyle(document.documentElement);
  const text = styles.getPropertyValue('--text').trim();
  const border = styles.getPropertyValue('--border').trim();
  const primary = styles.getPropertyValue('--primary').trim();
  const accent = styles.getPropertyValue('--accent').trim();
  const muted = styles.getPropertyValue('--muted').trim();

  const grid = { color: border };

  const baseOptions = {
    responsive: true,
    plugins: {
      legend: {
        labels: { color: text },
      },
    },
    scales: {
      x: { ticks: { color: muted }, grid },
      y: { ticks: { color: muted }, grid },
    },
  };

  const trendCtx = document.getElementById('trendChart');
  if (trendCtx) {
    charts.trend = new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: stats.trend.labels,
        datasets: [
          {
            label: 'Average Grade',
            data: stats.trend.values,
            borderColor: primary,
            backgroundColor: 'rgba(30, 77, 216, 0.18)',
            tension: 0.4,
            fill: true,
            pointRadius: 3,
          },
        ],
      },
      options: baseOptions,
    });
  }

  const barCtx = document.getElementById('kpiBarChart');
  if (barCtx) {
    charts.kpi = new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: stats.department_kpis.labels,
        datasets: [
          {
            label: 'Average Grade %',
            data: stats.department_kpis.values,
            backgroundColor: [primary, accent, '#f59e0b', '#10b981'],
            borderRadius: 8,
          },
        ],
      },
      options: baseOptions,
    });
  }

  const pieCtx = document.getElementById('completionPie');
  if (pieCtx) {
    charts.completion = new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: stats.completion.labels,
        datasets: [
          {
            data: stats.completion.values,
            backgroundColor: [primary, accent, '#ef4444'],
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            labels: { color: text },
            position: 'bottom',
          },
        },
      },
    });
  }

  const donutCtx = document.getElementById('gapDonut');
  if (donutCtx) {
    charts.gaps = new Chart(donutCtx, {
      type: 'doughnut',
      data: {
        labels: stats.gaps.labels,
        datasets: [
          {
            data: stats.gaps.values,
            backgroundColor: ['#0ea5e9', '#f97316', '#22c55e'],
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            labels: { color: text },
            position: 'bottom',
          },
        },
      },
    });
  }
};

const fetchStats = async () => {
  const statsEl = document.querySelector('[data-stats-url]');
  if (!statsEl) return;
  const url = statsEl.dataset.statsUrl;
  if (!url) return;
  try {
    const response = await fetch(url);
    if (!response.ok) return;
    const data = await response.json();
    buildCharts(data);
  } catch (error) {
    console.error('Failed to load stats', error);
  }
};

document.addEventListener('DOMContentLoaded', () => {
  const storedTheme = localStorage.getItem(STORAGE.theme) || 'light';
  const storedDir = localStorage.getItem(STORAGE.dir) || 'ltr';

  setTheme(storedTheme);
  setDirection(storedDir);

  const themeToggle = document.getElementById('themeToggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      localStorage.setItem(STORAGE.theme, next);
      setTheme(next);
      fetchStats();
    });
  }

  const rtlToggle = document.getElementById('rtlToggle');
  if (rtlToggle) {
    rtlToggle.addEventListener('click', () => {
      const next = document.documentElement.getAttribute('dir') === 'rtl' ? 'ltr' : 'rtl';
      localStorage.setItem(STORAGE.dir, next);
      setDirection(next);
    });
  }

  initReveal();
  initRefreshTime();
  fetchStats();
});
