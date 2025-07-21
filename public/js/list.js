//import './bootstrap'; //一応消さないでおく

$(function() {  //ページの読み込みが完了したときに、中の処理を実行する
    console.log('list.jsが読み込まれました');
    $('#kensaku').on('click',function(e){ //クリックされたときに以下の処理をする
        e.preventDefault(); //ページ遷移するのを防ぐ
        $('.loading').addClass('display-none'); //通信中のぐるぐるを消す

        //入力された検索条件を取得へ
        const search = $('#search').val();  //検索キーワード
        const company_id = $('#company_id').val();
        
        $.ajax({
            url: '/list', 
            method: 'GET',
            data: {
                search: search,
                company_id: company_id
            },
            dataType: 'json',
            success: function(response) {   //結果を画面に表示
                console.log(response)
                let html = '';
                response.products.forEach(product => {
                    html +=
                        `<tr>
                            <td>${product.id}</td>
                            <td>${product.product_name}</td>
                            <td><img class="imgfile" src="/${product.img_path ?? ''}" alt="商品画像"></td>
                            <td>${product.price}</td>
                            <td>${product.stock}</td>
                            <td>${product.company_id}</td>
                            <td>
                                <a class="btn btn-info" href="/pdetail/${product.id}">詳細</a>
                            </td>
                        </tr>`;
                });
                $('.TablE tbody').html(html);

                // 検索結果が0件のとき
                if (response.products.length === 0) {
                    $('.TablE tbody').html('<tr><td colspan="7" class="text-center">商品が見つかりません</td></tr>');
                }
            },
            error: function(xhr) {
                console.error('エラーが発生しました', xhr);
            }
        });
    });
});