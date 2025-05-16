<!-- resources/views/livewire/task-chart.blade.php -->
<div x-data="deliverableChart" class="w-full h-96">
    <div x-ref="chart" class="w-full h-full"></div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('deliverableChart', () => ({
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

                    this.$watch('chartData', (newData) => {
                        this.chart.updateOptions({
                            series: newData.series,
                            xaxis: {
                                categories: newData.categories
                            }
                        });
                    });

                    // Observa cambio de tema si usas Tailwind dark mode
                    const observer = new MutationObserver(() => {
                        this.chart.updateOptions(this.buildChartOptions());
                    });
                    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
                });
            },

            buildChartOptions() {
                return {
                    chart: {
                        type: 'line',
                        height: '100%',
                        background: 'transparent',
                        toolbar: { show: false },
                        fontFamily: 'inherit',
                    },
                    series: this.chartData.series,
                    xaxis: {
                        categories: this.chartData.categories,
                        labels: {
                            style: {
                                colors: this.isDarkMode ? '#cbd5e1' : '#475569', // slate-300 / slate-600
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: this.isDarkMode ? '#cbd5e1' : '#475569',
                            }
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    title: {
                        text: 'Distribución de la carga de tareas - ciclo de desarrollo',
                        align: 'left',
                        style: {
                            color: this.isDarkMode ? '#f8fafc' : '#1e293b', // slate-50 / slate-800
                            fontSize: '16px',
                            fontWeight: '600'
                        }
                    },
                    tooltip: {
                        theme: this.isDarkMode ? 'dark' : 'light'
                    },
                    grid: {
                        borderColor: this.isDarkMode ? '#334155' : '#e2e8f0', // slate-700 / slate-200
                    }
                };
            }
        }));
    });
</script>
