<template>
    <!-- {{$page.props.cart}} -->
    <div class="mb-3" v-for="c in $page.props.cart" :key="c">
       <CartItem :post="c[0]"  :pcount="c[1]"/>
    </div>
  </template>
  
  
  <script>
  import CartItem from "@/Fragment/CartItem.vue";
  export default {
    components: {
      CartItem,
    },
  };
  </script>
  