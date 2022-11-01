import ApexCharts from 'apexcharts';
import axios from 'axios';

// var dateToday = new Date();
// var year = dateToday.getFullYear();
// var month = (dateToday.getMonth() + 1).padStart(2, '0');

var urlProducao = '/gestor/producao/report/gramatura/json';
let series = [];
let categories = [];

axios({
  method: 'GET',
  url: urlProducao,
}).then(function(response) {
  if(response.data.length > 0){
      let array = response.data.map((e)=>{
          return e.gramatura.toString();
      });

      series.push({
          name: 'Biomassa estimada por gramatura',
          data: array,
      });

      let array2 = response.data.map((e)=>{
          return e.classificacao;
      });

      categories = array2;

      var options = {
        series: series,
        chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          horizontal: true,
        }
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: categories,
      }
      };

      var chart = new ApexCharts(document.querySelector("#chartProducao"), options);
      chart.render();
    }else{
      document.querySelector("#no-data").innerHTML = "Sem dados de gramatura para essa semana"
    }
  });