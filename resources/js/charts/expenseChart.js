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

    Alpine.data('myQuotationChart', () => ({
        chart: null,
        isLoading: true,
        isDropdownOpen: false,
        years: [],
        selectedYear: null,

        init() {
            this.fetchYears();
        },

        async fetchYears() {
            this.isLoading = true;
            try {
                const response = await fetch("/dashboard/api/my-quotation-years");
                this.years = await response.json();
                if (this.years.length > 0) {
                    this.selectYear(this.years[0]); // Select the most recent year by default
                } else {
                    this.isLoading = false; // No years to show, stop loading
                }
            } catch (error) {
                console.error("Failed to fetch years:", error);
                this.isLoading = false;
            }
        },

        selectYear(year) {
            this.selectedYear = year;
            this.isDropdownOpen = false;
            this.fetchChartData(year);
        },

        async fetchChartData(year) {
            this.isLoading = true;
            try {
                const response = await fetch(`/dashboard/api/my-quotation-summary?year=${year}`);
                const summaryData = await response.json();
                this.renderChart(summaryData);
            } catch (error) {
                console.error(`Failed to fetch summary data for ${year}:`, error);
            } finally {
                this.isLoading = false;
            }
        },

        renderChart(data) {
            if (!this.$refs.myQuotationChart) return;

            // Process data for ApexCharts
            const amounts = data.map(d => d.total_amount);
            const counts = data.map(d => d.quotation_count);

            const options = {
                series: [{
                    name: 'Total Amount',
                    data: amounts
                }],
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: { position: 'top' },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val, { dataPointIndex }) => {
                        const count = counts[dataPointIndex];
                        return count > 0 ? `${count}` : ''; // Show count as label, hide if zero
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#90A4AE"],
                        fontWeight: 'bold'
                    }
                },
                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    position: 'bottom', // Changed from 'top' for better layout
                    labels: { style: { colors: '#90A4AE', fontFamily: 'Inter, sans-serif' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    labels: {
                        show: true, // Keep y-axis labels to show scale
                        style: { colors: '#90A4AE', fontFamily: 'Inter, sans-serif' },
                        formatter: (val) => `৳${val / 1000}k`
                    }
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: (val) => `৳ ${val.toLocaleString()}`
                    }
                },
                grid: {
                    borderColor: '#e7e7e7',
                    strokeDashArray: 5,
                    yaxis: { lines: { show: true } },
                    xaxis: { lines: { show: false } }
                },
                title: {
                    // The title is now in the component's HTML, so we can remove it from here
                    text: '',
                }
            };

            if (this.chart) {
                this.chart.updateOptions(options);
            } else {
                this.chart = new ApexCharts(this.$refs.myQuotationChart, options);
                this.chart.render();
            }
        }
    }));


});
