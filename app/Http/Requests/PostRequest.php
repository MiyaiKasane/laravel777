<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() //authorizeメソッドではアクセスに対してフォームリクエストの使用を許可する(true)か拒否する(false)かをreturnする真偽値によって分岐させることができます。
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() //投稿する内容のルール
    {
        return [
            'productName' => 'required|max:100',
            'Image' => 'nullable|image|max:500',
            'Price' => 'required|integer|max:250',
            'Stock' => 'required|integer|max:250',
            'Choice' => 'required|max:100',
            'Comment' => 'nullable|string' //仕様書ではtextの指定だけど、text自体がルールとして対応してない・・・？
        ];
    }

    public function attributes() 
{
    return [
        'productName' => '商品名',
        'Image' => '商品画像',
        'Price' => '価格',
        'Stock' => '在庫',
        'Choice' => 'メーカー名',
        'Comment' => 'コメント'
    ];
}

public function messages() {  //投稿時の入力エラー文設定
    return [
        'productName.required' => ':attributeは必須項目です。',
        'Image.image' => ':attributeは画像ファイルである必要があります。',
        'Price.required' => ':attributeは必須項目です。',
        'Stock.required' => ':attributeは必須項目です。',':attributeは整数である必要があります',
        'Choice.required' => ':attributeは必須項目です。'
    ];
}
}
