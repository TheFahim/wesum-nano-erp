import ApexCharts from "apexcharts";

document.addEventListener('alpine:init', () => {
    Alpine.data('expenseChartComponent', () => ({
        // --- STATE ---
        chart: null,
        buttonText: 'This Month', // Initial button text
        isDropdownOpen: false,   // State to control the dropdown visibility

        // --- LIFECYCLE HOOK ---
        init() {
            // Fetch the data for the default period when the component loads.
            // Using a timeout to ensure the DOM is ready for ApexCharts.
            this.$nextTick(() => {
                this.fetchAndRenderChart('this_month');
            });
        },

        // --- METHODS ---

        // Called by the dropdown links to update the chart
        selectPeriod(period, text) {
            this.buttonText = text; // Update the button text.
            this.fetchAndRenderChart(period); // Fetch new data and update the chart.
            // The dropdown is closed via `@click` in the HTML, simplifying this function.
        },

        // Fetches data and renders/updates the chart
        async fetchAndRenderChart(period) {
            // Show a loading message while fetching
            this.$refs.chartContainer.innerHTML = '<p class="text-center text-gray-500 py-12">Loading Chart...</p>';

            try {
                // Use a proper URL helper in a real app, e.g., using Ziggy or a data attribute
                const response = await fetch(`/dashboard/expenses-chart-data?period=${period}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                // Clear loading message before rendering
                this.$refs.chartContainer.innerHTML = '';

                const options = this.getChartOptions(data);

                if (this.chart) {
                    // If chart exists, update it
                    this.chart.updateOptions(options);
                } else {
                    // Otherwise, create a new chart instance
                    this.chart = new ApexCharts(this.$refs.chartContainer, options);
                    this.chart.render();
                }

            } catch (error) {
                console.error('Failed to fetch or render chart data:', error);
                this.$refs.chartContainer.innerHTML = '<p class="text-red-500 text-center py-12">Failed to load chart data.</p>';
            }
        },

        // Helper to generate ApexCharts options object
        getChartOptions(data) {
            return {
                series: data.series || [],
                labels: data.labels || [],
                colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#E74694", "#9061F9", "#7E3AF2"],
                chart: {
                    height: 320,
                    width: "100%",
                    type: "donut",
                },
                stroke: {
                    colors: ["transparent"],
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: { show: true, fontFamily: "Inter, sans-serif", offsetY: 20 },
                                total: {
                                    showAlways: true,
                                    show: true,
                                    label: "Total Expenses",
                                    fontFamily: "Inter, sans-serif",
                                    color: "#64748B",
                                    // Use Unicode Taka sign directly
                                    formatter: () => `${data.total} ৳`
                                },
                                value: {
                                    show: true,
                                    fontFamily: "Inter, sans-serif",
                                    color: "#64748B",
                                    offsetY: -20,
                                    formatter: (value) => `${parseFloat(value).toLocaleString()} ৳`
                                },
                            },
                            size: "80%",
                        },
                    },
                },
                grid: { padding: { top: -2 } },
                dataLabels: { enabled: false },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                    labels: { colors: '#64748B', useSeriesColors: false },
                },
            };
        }
    }));
});
