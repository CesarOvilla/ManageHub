<div x-data="donutChart" class="w-full h-96">
    <div x-ref="chart" class="w-full h-full"></div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('donutChart', () => ({
        chartData: @entangle('chartData'),
        chart: null,

        get isDarkMode() {
            return document.documentElement.classList.contains('dark');
        },

        init() {
            this.$nextTick(() => {
                if (!this.chartData.series || this.chartData.series.length === 0) {
                    console.error('No hay datos para el gráfico');
                    return;
                }

                this.chart = new ApexCharts(this.$refs.chart, this.buildChartOptions());
                this.chart.render();

                // Escucha cambios dinámicos de modo claro/oscuro
                const observer = new MutationObserver(() => {
                    this.chart.updateOptions(this.buildChartOptions());
                });
                observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            });
        },

        buildChartOptions() {
            return {
                chart: {
                    type: 'donut',
                    height: '100%',
                    background: 'transparent',
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                },
                labels: this.chartData.labels,
                series: this.chartData.series,
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    fontSize: '14px',
                                    color: this.isDarkMode ? '#e2e8f0' : '#334155', // slate-200 / slate-700
                                    formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0),
                                }
                            }
                        }
                    }
                },
                title: {
                    text: 'Finalización del seguimiento de tareas (histórico)',
                    align: 'center',
                    style: {
                        fontSize: '16px',
                        color: this.isDarkMode ? '#f1f5f9' : '#1e293b', // slate-50 / slate-800
                        fontWeight: 600
                    }
                },
                tooltip: {
                    theme: this.isDarkMode ? 'dark' : 'light',
                    y: {
                        formatter: (val) => val
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        colors: this.isDarkMode ? '#cbd5e1' : '#334155', // slate-300 / slate-700
                    }
                },
                dataLabels: {
                    style: {
                        colors: [this.isDarkMode ? '#f8fafc' : '#1e293b']
                    }
                }
            };
        }
    }));
});
</script>
