
const chart = {

    data() {
        return {
            graph: null,
            bar_graph: null,
            default_graph_color: "#02b102",
            graph_data: {},
            show_graph : "",
        }
    },
    mounted() {
        var app = this
        // var app = this;
        // var labels = ["JAN", "FEB", "MAR", "APR", "MAY"]
        // var data = [{
        //     data: [4, 13, 12, 6, 19],
        //     borderWidth: 1,
        //     fill: true,
        //     pointRadius: 2,
        //     lineTension: 0,
        //     borderColor: "green",
        // }];

        // app.createGraph('this-graph', 'line', labels, data, app.opt_default)

        

        if($("#this-graph").length > 0){
            $.ajax({
                url: base_url +"/getGraphData",
                success(data){
                    app.graph_data = data;
                    app.show_graph = "status";
                    app.createGraphServer('this-graph', app.graph_data.status_graph)
                    
                }
            })
            //app.createGraphServer()
        }

        this.$nextTick(function () {
            window.setInterval(() => {
                if(app.show_graph == "status"){
                    app.createGraphServer('this-graph', app.graph_data.currency_graph)
                    app.show_graph = "currency"
                }else{
                    app.createGraphServer('this-graph', app.graph_data.status_graph)
                    app.show_graph ="status"
                }
                
            },  20 * 1000);
        })

    },
    methods: {

        createGraph(id, type, labels, data, options, withGradient = false) {
            var app = this;
            var graph = $("#" + id);



            if (withGradient) {

                var graph = document.getElementById(id).getContext('2d');
                for (var i = 0; i < data.length; i++) {
                    var gradient_color = graph.createLinearGradient(0, 0, 0, 170);
                    gradient_color.addColorStop(0, data[i].gradientColor.stop);
                    gradient_color.addColorStop(0.6, data[i].gradientColor.start);
                    gradient_color.addColorStop(0.8, data[i].gradientColor.start);
                    gradient_color.addColorStop(1, data[i].gradientColor.start);
                    data[i].backgroundColor = gradient_color;

                }


            }



            var myChart = new Chart(graph, {
                type: type,
                data: {
                    labels: labels,
                    datasets: data,
                },
                options: options
            });

        },
        createGraphServer(id, data){
            var app = this
            var graph = $("#" +id)
            var chart = new Chart(graph, data)
        }
    }


};

export default chart;