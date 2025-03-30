import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    api_key: string;
}

export interface Order {
    id: string
    user_id: number
    total_price: string
    discount: string
    total_discount: string
    tax: string
    total_tax: string
    shipping_cost: string
    grand_total: string
    currency: string
    payment_method: string
    status: string
    success_url: string
    cancel_url: string
    failure_url: string
    extras: OrderExtras,
    created_at: string,
    order_items: OrderItem[],
    total_item_discount: string,
    total_item_tax: string,
}

export interface OrderExtras {
    [key: string]: string | number | boolean | object | null
}

export interface OrderItem {
    id: number
    order_id: string
    name: string
    price: string
    discount: string
    tax: string
    grand_total: string
    quantity: string
    thumbnail: string
    extras: OrderItemExtras,
    total_price: string,
}

export interface OrderItemExtras {
    [key: string]: string | number | boolean | object | null
}

export type BreadcrumbItemType = BreadcrumbItem;
