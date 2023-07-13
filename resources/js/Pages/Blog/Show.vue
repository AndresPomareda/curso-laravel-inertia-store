<template>
  <web-layout>
    <div class="container">
      <div class="card">
        <div class="card-body">
          <img class="w-full rounded-md shadow-md my-4" :src="post.image ?? '/image/default.jpg'" alt="" />

          <h4 class="text-center text-5xl mb-3">{{ post.title }}</h4>

          <p class="my-4 ml-2">
            <span class="text-sm text-gray-500 italic font-bold uppercase tracking-widest">
                        {{ post.date }}</span>
            <span class="ml-4 rounded-md bg-purple-500 py-1 px-2 text-white">
                {{ post.category.title }}
            </span>
            <span class="ml-4 rounded-md bg-purple-500 py-1 px-2 text-white">
                {{ post.type }}
            </span>
          </p>

          <div v-if="post.type == 'advert'">
            <cart-item :post="post" />
            <cart />
          </div>

          <div v-html="post.text"></div>

          <hr class="my-8" />
        </div>
      </div>
      <GeneralStep :errors="errors" />
    </div>
  </web-layout>
</template>

<script>
import WebLayout from "@/Layouts/WebLayout.vue";
import GeneralStep from "@/Pages/Contact/General/Step.vue";

import CartItem from "@/Fragment/CartItem.vue";
import Cart from "@/Fragment/Cart.vue";

export default {
  data() {
    return {};
  },
  components: {
    WebLayout,
    GeneralStep,
    Cart,
    CartItem
  },
  props: {
    post: Object,
    errors: Object,
  },
};
</script>
