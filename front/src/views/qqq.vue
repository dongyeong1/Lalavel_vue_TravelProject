<template>
  <div>
    <button @click="isOpen = !isOpen">Toggle</button>

    <collapse-transition>
      <div v-show="isOpen">This div will open and close smoothly!</div>
    </collapse-transition>
  </div>
</template>

<script>
import { CollapseTransition } from "@ivanv/vue-collapse-transition";

export default {
  components: {
    CollapseTransition,
  },
  data() {
    return {
      isOpen: false, // closed by default
    };
  },
};
</script>