import ApexCharts from "apexcharts";
import targetOptions from "./targetChart";



if (document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("bar-chart"), targetOptions);
    chart.render();
}
