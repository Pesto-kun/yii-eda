/**
 * File:
 * Date: 15.09.15 - 15:40
 *
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

function processCart(type, id) {

    var block = $('#dish-'+id);

    $.ajax({
        url: '/ajax/cart/' + type,
        data: {id: id},
        method: 'POST',
        dataType: 'json',
        beforeSend: function(){
            block.showLoading();
        },
        success: function(data){
            if(data.status == 'success') {
                block.hideLoading();
                block.find('.in-cart').text(data.amount);
            } else if(data.status = 'error') {
                alert(data.message);
                block.hideLoading();
            } else {
                alert("Unknown error!")
            }
        },
        error: function(data) {
            block.hideLoading();
            alert('Ajax error!')
        }
    });
}