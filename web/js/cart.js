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
                block.find('.in-cart').text(data.amount);
            } else if(data.status = 'error') {
                var modal = $('#cartModal');
                modal.find('.modal-body').text(data.message);
                modal.modal('show');
            } else {
                alert("Unknown error!")
            }
        },
        error: function(data) {
            alert('Ajax error!')
        }
    });
    block.hideLoading();
}

$(document).ready(function(){
    $('#checkout-cart').on('click', function(){

        var block = $('#checkout-fields');
        var result = false;

        $.ajax({
            url: '/ajax/cart/available',
            method: 'GET',
            dataType: 'json',
            async: false,
            beforeSend: function(){
                block.showLoading();
            },
            success: function(data){
                if(data.status == 'success') {
                    result = true;
                } else if(data.status = 'error') {
                    var modal = $('#cartModal');
                    modal.find('.modal-body').text(data.message);
                    modal.modal('show');
                } else {
                    alert("Unknown error!");
                }
            },
            error: function(data) {
                alert('Ajax error!');
            }
        });
        block.hideLoading();
        return result;
    });
});