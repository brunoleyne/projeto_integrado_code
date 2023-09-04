require('pace-progress/pace');

$(document).ajaxStart(function () {
    Pace.start();
}).ajaxStop(function () {
    Pace.stop();
});
