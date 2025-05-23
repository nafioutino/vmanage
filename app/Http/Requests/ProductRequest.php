<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Autoriser les utilisateurs authentifiés avec les rôles appropriés
        return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isApprovisionneur());
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048', // 2MB max
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];

        // Si c'est une création, le SKU est obligatoire et unique
        if ($this->isMethod('post')) {
            $rules['sku'] = 'required|string|max:50|unique:products,sku';
        }
        
        // Si c'est une mise à jour, le SKU doit être unique sauf pour le produit actuel
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['sku'] = ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($this->product)];
        }

        return $rules;
    }
}