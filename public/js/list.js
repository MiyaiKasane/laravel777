//import './bootstrap'; //一応消さないでおく

function searchProducts() {  //★1: searchProductsの開始
    console.log('list.jsが読み込まれました');
    $('#kensaku').on('click',function(e){ //★2: クリックされたときに以下の処理をする
        console.log('検索がクリックされました');
        e.preventDefault(); //ページ遷移するのを防ぐ
        $('.loading').addClass('display-none'); //通信中のぐるぐるを消す

        //入力された検索条件を取得へ
        const search = $('#search').val();  //検索キーワード
        const company_id = $('#company_id').val();
        const max_price = $('#max_price').val();  //上限価格で検索
        const min_price = $('#min_price').val();  //下限価格で検索
        const max_stock = $('#max_stock').val();  //上限在庫で検索
        const min_stock = $('#min_stock').val();  //下限在庫で検索
        console.log('検索条件:', search, company_id, max_price, min_price, max_stock, min_stock);

        $.ajax({ // ★3: Ajax検索の処理
            url: 'list', 
            method: 'GET',
            data: { 
                search: search, 
                company_id: company_id,
                max_price: max_price,
                min_price: min_price,
                max_stock: max_stock,
                min_stock: min_stock
            },
            dataType: 'json',

            success: function(response) {   // ★4: Ajax成功時
                let html = '';
                response.products.forEach(product => { 
                    html +=
                        `<tr>
                            <td>${product.id}</td>
                            <td>${product.product_name}</td>
                            <td><img class="imgfile" src="${product.img_path ?? ''}" alt="商品画像"></td>
                            <td>${product.price}</td>
                            <td>${product.stock}</td>
                            <td>${product.company ? product.company.company_name: ''}</td>
                            <td>
                                <a class="detail btn-info" href="pdetail/${product.id}">詳細</a>
                                <button class="delete" data-id="${product.id}">削除</button>
                            </td>
                        </tr>`;
                });
                $('.TablE tbody').html(html);

                // 検索結果が0件のとき
                if (response.products.length === 0) {
                    $('.TablE tbody').html('<tr><td colspan="7" class="text-center">商品が見つかりません</td></tr>');
                }

                //tablesorterに一覧の内容が変更したことをしらせる
                const $table = $('#thsorter'); //「id=thsorter」のデータを$tableとして定義する
                console.log( $table.data('tablesorter') );
                if($table.data('tablesorter')){ //tablesorterの中身にあるデータを確認してる
                    $table.trigger("update"); //これがないと検索後のソートがうまくいかなくなる。（検索前後のデータがどちらも表示されてしまう）
                    $table.trigger('sorton', [[[0,1]]]); //「ID列を降順で並べ直して」と指示している
                }
            }, // ★4の終わり

            error: function(xhr) {
                console.error('エラーが発生しました', xhr);
            }
        }); // ★3の終わり
    }); //★2の終わり
}; //★1の終わり

console.log('jsの削除処理が読み込まれました');  //削除処理は上記の検索処理とは別にしておく
$(document).on('click', '.delete', function(e) { // ★5: 削除ボタンがクリックされたとき
    e.preventDefault(); //ページ遷移するのを防ぐ
        const id = $(this).data('id');
        const $deleteButton = $(this);
        
        console.log('非同期の削除:', id);
        console.log('削除ボタンおせた', id);
            
        if (!confirm('削除しますか？')) return;
        $.ajax({  //ajax:削除の処理
                url: 'destroy/' + id,// 必要に応じてパス修正,
                type: 'DELETE',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function() {// 再検索や行の削除など
                    alert('削除しました');
                    $deleteButton.closest('tr').fadeOut(300, function() {
                        $(this).remove();
                        });
                    },

                error: function(xhr) {
                    alert('削除に失敗しました');
                    }
            }); //ajax:削除の終わり
}); // ★5の終わり

    //ページロード時に呼び出す
    $(function() {
        searchProducts();
    });