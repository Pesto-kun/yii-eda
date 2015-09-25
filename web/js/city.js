/**
 * File:
 * Date: 25.09.15 - 13:56
 *
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

function changeCity() {

    //var block = $('select[name="visitor_city"]');
    //var city = block.val();

    window.location.href = '/?city=' + $('select[name="visitor_city"]').val();
    //
    //$.ajax({
    //    url: '',
    //    data: {city: city},
    //    method: 'POST',
    //    dataType: 'json',
    //    beforeSend: function(){
    //        block.addClass('loading');
    //    },
    //    success: function(data){
    //        if(data.status == 'success') {
    //            //true
    //        } else if(data.status = 'error') {
    //            alert(data.message);
    //        } else {
    //            alert("Unknown error!")
    //        }
    //    },
    //    error: function(data) {
    //        alert('Ajax error!')
    //    }
    //});
    //block.removeClass('loading');
}