var currentTab;
var composeCount = 0;
$(function () {
    $("#myTab").on("click", "a", function (e) {
        e.preventDefault();

        $(this).tab('show');
        $currentTab = $(this);
    });

    registerCloseEvent();
});


function registerCloseEvent() {

    $(".closeTab").click(function () {

      
        var tabContentId = $(this).parent().attr("href");
        $(this).parent().parent().remove(); 
        $('#myTab a:last').tab('show');
        $(tabContentId).remove(); 

    });
}

function showTab(tabId) {
    $('#myTab a[href="#' + tabId + '"]').tab('show');
}

function getCurrentTab() {
    return currentTab;
}

function createNewTabAndLoadUrl(parms, url, loadDivSelector,userid) {

    $('#'+loadDivSelector+'conv').load(url, function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error getting details ! ";
            $('#'+loadDivSelector+'conv').html(msg + xhr.status + " " + xhr.statusText);
            $('#'+loadDivSelector+'conv').html("Load Ajax Content Here...");
        }else{
        $('#'+loadDivSelector+'conv').html(response);
        
        $('#timer').timer({
    duration: '5s',
    callback: function() {
         if($('#'+loadDivSelector+'conv').hasClass('active')) {
       		$.ajax({
			url: 'get.php?id='+userid,
			success: function(data) {
				$('#messages').html(data);
                }
		});
        }
    },
    repeat: true //repeatedly calls the callback you specify
});
        

}
        });

}

function getElement(selector) {
    var tabContentId = $currentTab.attr("href");
    return $("" + tabContentId).find("" + selector);

}


function removeCurrentTab() {
    var tabContentId = $currentTab.attr("href");
    $currentTab.parent().remove(); 
    $('#myTab a:last').tab('show');
    $(tabContentId).remove();
    $('#messages').html('');
}

function createconversion(clicked){
var userid=clicked.id;
var username=clicked.text;
var token=clicked.title;
var url = "send.php?id="+userid+"&token="+token;
$('.nav-tabs').append('<li><a href="#' + userid + 'conv"><button class="close closeTab" onclick="removeCurrentTab()" type="button" >×</button>'+ username +'</a></li>');
$('.tab-content').append('<div class="tab-pane" id="' + userid + 'conv"></div>');
createNewTabAndLoadUrl("",url,userid,userid);
}
