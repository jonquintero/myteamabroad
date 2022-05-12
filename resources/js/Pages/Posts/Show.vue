<template>
  <div>
    <Head :title="Post" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/posts">My Posts</Link>
      <span class="text-indigo-400 font-medium">/</span>
      Show
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
          <textarea-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-11/12" label="Description" />
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import TextareaInput from '@/Shared/TextareaInput'

export default {
  components: {
    Head,
    Link,
    TextInput,
    TextareaInput,

  },
  layout: Layout,
  props: {
    post: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: this.post.title,
        description: this.post.description,
      }),
    }
  },

}
</script>
