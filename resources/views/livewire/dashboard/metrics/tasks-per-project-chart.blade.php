<div x-data="projectTasksBarChart" class="w-full h-96">
    <div x-ref="chart" class="w-full h-full"></div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('projectTasksBarChart', () => ({
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

                    // Observa el cambio de modo (claro/oscuro)
                    const observer = new MutationObserver(() => {
                        this.chart.updateOptions(this.buildChartOptions());
                    });
                    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
                });
            },

            buildChartOptions() {
                return {
                    chart: {
                        type: 'bar',
                        height: '100%',
                        stacked: true,
                        background: 'transparent',
                        toolbar: { show: false },
                        fontFamily: 'inherit'
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 4,
                            dataLabels: {
                                total: {
                                    enabled: true,
                                    style: {
                                        fontSize: '13px',
                                        fontWeight: 700,
                                        color: this.isDarkMode ? '#e2e8f0' : '#334155' // slate-200 / slate-700
                                    }
                                }
                            }
                        }
                    },
                    series: this.chartData.series,
                    xaxis: {
                        categories: this.chartData.categories,
                        labels: {
                            style: {
                                colors: this.isDarkMode ? '#cbd5e1' : '#334155', // slate-300 / slate-700
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: this.isDarkMode ? '#cbd5e1' : '#334155',
                            }
                        }
                    },
                    title: {
                        text: 'Tareas por proyecto - ciclo de desarrollo (Histórico)',
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 600,
                            color: this.isDarkMode ? '#f8fafc' : '#1e293b', // slate-50 / slate-800
                        }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: this.isDarkMode ? '#e2e8f0' : '#334155',
                        }
                    },
                    tooltip: {
                        theme: this.isDarkMode ? 'dark' : 'light',
                        y: {
                            formatter: (val) => val
                        }
                    },
                    grid: {
                        borderColor: this.isDarkMode ? '#334155' : '#e2e8f0', // slate-700 / slate-200
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
