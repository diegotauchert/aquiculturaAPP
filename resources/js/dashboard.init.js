import ApexCharts from 'apexcharts';
import axios from 'axios';

var urlProducao = '/gestor/producao/report/gramatura/json';
var urlProducaoTotal = '/gestor/producao/report/gramatura/total/json';
var urlViveirosStatus = '/gestor/viveiros/status/report/json';
var urlProdutosEstoque = '/gestor/produtos/estoque/report/json';

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
    axios({
      method: 'GET',
      url: urlProducaoTotal,
    }).then(function(response) {
      if(response.data.length > 0){
          let array = response.data.map((e)=>{
              return e.gramatura.toString();
          });
    
          series.push({
              name: 'Biomassa estimada por gramatura total',
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

          document.querySelector("#current-week").innerHTML = " | Dados Total no Sistema por não ter registros na semana atual";
        }else{
          document.querySelector("#no-data").innerHTML = "Sem dados de gramatura para essa semana"
        }
      });
    }
  });

  axios({
    method: 'GET',
    url: urlViveirosStatus,
  }).then(function(response) {
    if(response.data.length > 0){
      let producao = 0;
      let manutencao = 0;
      let parado = 0;

      response.data.forEach((status) =>{
        if(status.situacao == 1){
          producao++;
        }else if(status.situacao == 2){
          manutencao++;
        }else if(status.situacao == 3){
          parado++;
        }
      });

      let viveirosStatus = [producao, manutencao, parado];

      var options = {
        series: viveirosStatus,
        labels: ['Produzindo', 'Manutenção', 'Entre Ciclo'],
        chart: {
        type: 'donut',
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: '100%',
            height: '100%'
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
      };


      var chart = new ApexCharts(document.querySelector("#chartViveiros"), options);
      chart.render();
    }
  });



  axios({
    method: 'GET',
    url: urlProdutosEstoque,
  }).then(function(response) {
    if(response.data?.length > 0){
      let data = [];

      for (const estoque of response.data) {
        data.push({
          x: estoque.produto.toString(),
          y: Number(estoque.quantidade),
          goals: [
            {
              name: 'Mínimo',
              value: Number(estoque.minimo),
              strokeHeight: 5,
              strokeColor: '#930000'
            }
          ],
        });
      };

      if(data.length > 0){
        var options = {
          series: [
            {
              name: 'Estoque Atual',
              data: data
            }
          ],
          chart: {
            height: 327,
            type: 'bar'
          },
        plotOptions: {
          bar: {
            columnWidth: '60%'
          }
        },
        colors: ['#00E396'],
        dataLabels: {
          enabled: false
        },
        legend: {
          show: true,
          showForSingleSeries: true,
          customLegendItems: ['Quantidade', 'Mínimo'],
          markers: {
            fillColors: ['#00E396', '#930000']
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chartRacao"), options);
        chart.render();
      }
    }
  });