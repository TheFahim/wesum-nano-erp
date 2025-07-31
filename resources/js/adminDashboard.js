import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';


document.addEventListener('alpine:init', () => {
    Alpine.data('topSummery', () => ({
        init() {
            const api = '/dashboard/api/top-summary';
            this.fetchTopSummary(api);
        },

        sellRevenue: 0,
        collectableBill: 0,
        buyingPriceLeft: 0,
        totalPaid: 0,
        totalDue: 0,
        totalExpense: 0,
        fetchTopSummary(api) {
            fetch(api)
                .then(response => response.json())
                .then(data => {

                    this.sellRevenue = data.sellRevenue;
                    this.collectableBill = data.collectableBill;
                    this.buyingPriceLeft = data.buyingPriceWarning;
                    this.totalPaid = data.totalPaid;
                    this.totalDue = data.totalDue;
                    this.totalExpense = data.totalExpense;
                })
                .catch(error => console.error('Error fetching top summary:', error));
        },
    }));

    Alpine.data('expenseAdmin', () => ({
        isDropdownOpen: false,
        chart: null,
        expense: 0,
        filters: [
            { label: 'This Month', value: 'this_month' },
            { label: 'Last Month', value: 'last_month' },
            { label: 'This Year', value: 'this_year' },
            { label: 'Last Year', value: 'last_year' },
            { label: 'Last 90 days', value: 'last_90_days' },
            { label: 'Last 6 months', value: 'last_6_months' }
        ],
        selectedFilter: { label: 'This Month', value: 'this_month' },

        init() {
            this.fetchExpense();
            this.initChart();
        },

        fetchExpense() {
            const api = `/dashboard/api/expense?filter=${this.selectedFilter.value}`;
            fetch(api)
                .then(response => response.json())
                .then(data => {
                    this.expense = data.total_expense;
                    // Pass the user-specific expense data to the chart
                    this.updateChart(data.expenses);
                })
                .catch(error => console.error('Error fetching expense:', error));
        },

        selectFilter(filter) {
            this.selectedFilter = filter;
            this.isDropdownOpen = false;
            this.fetchExpense();
        },

        initChart() {
            const options = {
                series: [{
                    name: "Expense",
                    data: [],
                    color: "#F05252",
                }],
                chart: {
                    type: "bar",
                    height: 350,
                    toolbar: {
                        show: false
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: "100%",
                        borderRadius: 6,
                    },
                },
                // --- ADDED/MODIFIED OPTIONS FOR COLORS ---
                dataLabels: {
                    enabled: false,
                },
                grid: {
                    show: true,
                    borderColor: '#90A4AE', // A neutral gray for grid lines
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -20
                    },
                },
                xaxis: {
                    categories: [],
                    tickAmount: 5,
                    labels: {
                        style: {
                            colors: '#90A4AE', // Color for x-axis labels
                            fontFamily: "Inter, sans-serif",
                        },
                    },
                    axisTicks: { show: true },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#90A4AE', // Color for y-axis labels
                            fontFamily: "Inter, sans-serif",
                        }
                    }
                },
                // --- END OF ADDED/MODIFIED OPTIONS ---
            };
            this.chart = new ApexCharts(document.getElementById("bar-chart"), options);
            this.chart.render();
        },

        // --- MODIFIED FUNCTION ---
        updateChart(data) {
            // The new 'data' is the 'expenses' array from the API response
            // Each item is now { user_name: 'John Doe', total_expense: 500 }

            // Map user names to the chart's categories
            const categories = data.map(item => item.user_name);
            const seriesData = data.map(item => item.total_expense);

            this.chart.updateOptions({
                xaxis: {
                    categories: categories, // Update categories to be user names
                },
                series: [{
                    data: seriesData,
                }],
            });
        }
    }));

    Alpine.data('dueAdmin', () => ({
        isDropdownOpen: false,
        totalDue: 0,
        users: [],
        filters: [
            { label: 'This Month', value: 'this_month' },
            { label: 'Last Month', value: 'last_month' },
            { label: 'This Year', value: 'this_year' },
            { label: 'Last Year', value: 'last_year' },
            { label: 'Last 90 days', value: 'last_90_days' },
            { label: 'Last 6 months', value: 'last_6_months' }
        ],
        selectedFilter: { label: 'This Month', value: 'this_month' },
        tooltip: {
            show: false,
            text: '',
            x: 0,
            y: 0,
        },
        init() {
            this.fetchDueData();
        },
        fetchDueData() {
            const apiUrl = `/dashboard/api/due?filter=${this.selectedFilter.value}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    this.totalDue = data.total_due;
                    this.users = data.users;
                })
                .catch(error => console.error('Error fetching due data:', error));
        },
        selectFilter(filter) {
            this.selectedFilter = filter;
            this.isDropdownOpen = false;
            this.fetchDueData();
        },
        formatCurrency(value) {
            if (typeof value !== 'number') value = 0;
            return value.toLocaleString('en-US') + ' ৳';
        },
        showTooltip(event, dueAmount, userName) {
            // Set the structured data for the tooltip
            this.tooltip.userName = userName;
            this.tooltip.dueAmount = this.formatCurrency(dueAmount);

            // Position tooltip slightly below and to the right of the cursor
            this.tooltip.x = event.clientX + 15;
            this.tooltip.y = event.clientY + 15;
            this.tooltip.show = true;
        },
        hideTooltip() {
            this.tooltip.show = false;
        }
    }));


    Alpine.data('targetAdmin', () => ({
        isDropdownOpen: false,
        chart: null,
        year: new Date().getFullYear(),
        stats: { target: 0, achieved: 0, remaining: 0 },
        // Filters relevant to a yearly target
        filters: [
            { label: 'This Year', value: 'this_year' },
            { label: 'Last Year', value: 'last_year' },
        ],
        selectedFilter: { label: 'This Year', value: 'this_year' },

        init() {
            this.initChart();
            this.fetchTargetData();
        },

        fetchTargetData() {
            const apiUrl = `/dashboard/api/target?filter=${this.selectedFilter.value}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    this.year = data.year;
                    this.stats = data.stats;
                    // Update the chart with the new data from the API
                    this.chart.updateSeries([{ name: 'Actual', data: data.chartData }]);
                })
                .catch(error => console.error('Error fetching target data:', error));
        },

        selectFilter(filter) {
            this.selectedFilter = filter;
            this.isDropdownOpen = false;
            this.fetchTargetData();
        },

        initChart() {
            const options = {
                series: [{ name: 'Actual', data: [] }],
                chart: {
                    height: 300,
                    type: 'bar',
                    toolbar: { show: false },
                    foreColor: '#64748B'
                },
                plotOptions: { bar: { horizontal: true } },
                colors: ['#00E396'],
                dataLabels: {
                    formatter: function (val, opt) {
                        const goals = opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]?.goals;
                        if (goals && goals.length) {
                            // Format with K/M for brevity
                            const format = n => (n >= 1000 ? (n / 1000).toFixed(0) + 'K' : n);
                            return `${format(val)} / ${format(goals[0].value)}`;
                        }
                        return val;
                    },
                },
                legend: {
                    show: true,
                    showForSingleSeries: true,
                    customLegendItems: ['Achieved', 'Target'],
                    markers: { fillColors: ['#00E396', '#775DD0'] },
                },
                xaxis: {
                    labels: {
                        formatter: function (val) {
                            if (val >= 1000000) return (val / 1000000).toFixed(1) + 'M';
                            if (val >= 1000) return (val / 1000).toFixed(0) + 'K';
                            return val;
                        }
                    }
                }
            };
            this.chart = new ApexCharts(document.querySelector("#target-chart"), options);
            this.chart.render();
        },

        formatCurrency(value) {
            if (typeof value !== 'number') value = 0;
            return value.toLocaleString('en-US'); // Using a simple number format for this one
        }
    }));

    Alpine.data('adminQuotation', () => ({
        isDropdownOpen: false,
        filters: [
            { label: 'This Month', value: 'this_month' },
            { label: 'This Year', value: 'this_year' },
            { label: 'Last Year', value: 'last_year' },
            { label: 'All Time', value: 'all' },
        ],
        selectedFilter: { label: 'This Month', value: 'this_month' },

        init() {
            this.fetchAndRenderChart();
        },

        selectFilter(filter) {
            this.selectedFilter = filter;
            this.isDropdownOpen = false;
            this.fetchAndRenderChart();
        },

        rawData: [],

        async fetchAndRenderChart() {
            try {
                const response = await fetch(`/dashboard/api/quotation?filter=${this.selectedFilter.value}`);
                if (!response.ok) throw new Error('Network response was not ok');
                const fetchedData = await response.json();
                console.log(fetchedData);

                const rawData = fetchedData.map(data => {
                    return {
                        user: data.user.name,
                        quotationId: data.quotation_no,
                        amount: data.total
                    }
                });

                this.updateChart(rawData);
            } catch (error) {
                console.error("Failed to fetch chart data:", error);
                // Optionally, show an error message in the UI
            }
        },

        // This helper function processes the data from your API
        processChartData(data) {
            const dataByUser = {};
            // Group quotations by user
            data.forEach(item => {
                if (!dataByUser[item.user]) {
                    dataByUser[item.user] = [];
                }
                dataByUser[item.user].push({ amount: item.amount, id: item.quotationId });
            });

            const userCategories = Object.keys(dataByUser);
            let maxQuotes = 0;

            // Create Y-axis labels with counts, e.g., "User A (3)"
            const yAxisLabels = userCategories.map(user => {
                const count = dataByUser[user].length;
                if (count > maxQuotes) maxQuotes = count;
                return `${user} (${count})`;
            });

            const series = [];
            const quoteIdLookup = []; // A parallel array to store IDs for the tooltip

            // Build the series data
            for (let i = 0; i < maxQuotes; i++) {
                const seriesData = [];
                const idData = [];
                userCategories.forEach(user => {
                    if (dataByUser[user][i]) {
                        seriesData.push(dataByUser[user][i].amount);
                        idData.push(dataByUser[user][i].id);
                    } else {
                        seriesData.push(null); // No quote for this user at this position
                        idData.push(null);
                    }
                });
                series.push({ name: ` ${i + 1}`, data: seriesData });
                quoteIdLookup.push(idData);
            }
            return { series, yAxisLabels, quoteIdLookup };
        },

        updateChart(rawData) {
            if (!this.$refs.quotationChart) return;

            const { series, yAxisLabels, quoteIdLookup } = this.processChartData(rawData);

            const options = {
                series: series,
                chart: {
                    type: 'bar',
                    height: 450, // Increased height to prevent labels from being cut off
                    stacked: true,
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    },
                },
                stroke: {
                    width: 1,
                    colors: ['#fff']
                },
                xaxis: {
                    categories: yAxisLabels, // Users are now on the X-axis for horizontal chart
                    title: {
                        text: 'Total Quotation Amount ($)',
                        style: { fontFamily: "Inter, sans-serif", color: "#90A4AE" }
                    },
                    labels: {
                        style: { colors: '#90A4AE', fontFamily: "Inter, sans-serif" },
                    }
                },
                yaxis: {
                    title: {
                        text: 'Users',
                        style: { fontFamily: "Inter, sans-serif", color: "#90A4AE" }
                    },
                    labels: {
                        style: { colors: '#90A4AE', fontFamily: "Inter, sans-serif" },
                    }
                },
                tooltip: {
                    y: {
                        formatter: (val, { seriesIndex, dataPointIndex }) => {
                            const quotationId = quoteIdLookup[seriesIndex][dataPointIndex];
                            return `${quotationId}: ৳${val.toLocaleString()}`;
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                legend: {
                    show: false, // Hide the legend as it's not meaningful here
                    position: 'top',
                    horizontalAlign: 'left'
                }
            }

            var chart = new ApexCharts(document.querySelector("#quotation"), options);
            chart.render();
            // If chart is already initialized, just update it for better performance

        }
    }));


});
