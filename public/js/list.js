import './bootstrap'; //一応消さないでおく

$(document).ready(function() {  //ページの読み込みが完了したときに、中の処理を実行する
    console.log('list.jsが読み込まれました');
    $('#kensaku').on('click',function(e){ //クリックされたときに以下の処理をする
        e.preventDefault(); //ページ遷移するのを防ぐ

        //入力された検索条件を取得へ
        const search = $('#search').val();  //検索キーワード
        const companyId = $('#company_id').val();

        $.ajax({
            url: '/api/list',
            method: 'GET',
            data: {
                search: search,
                company_id: companyId
            },
            success: function(response) {   //結果を画面に表示
                let html = '';
                response.peoducts.forEach(product => {
                    html += '<li>${product.product_name}<li>';
                });
                $('#product-list').html(html); //結果をリストに反映
            },
            error: function(xhr) {
                console.error('エラーが発生しました', xhr);
            }
        });
    });
});