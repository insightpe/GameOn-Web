$(function(){ 
    UiDashboard.init(); 
});

var UiDashboard = function() {
    return {
        init: function() {
            App.initDashboardPageCharts();
            App.initVectorMap();
        },
    }
}();