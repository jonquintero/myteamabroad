<template>
  <div>
    <Head title="Posts" />
    <h1 class="mb-8 text-3xl font-bold">My Posts</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Order Published:</label>
        <select v-model="form.order" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="asc">ASC</option>
          <option value="desc">DESC</option>
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/posts/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Posts</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Title</th>
            <th class="pb-4 pt-6 px-6">Description</th>
            <th class="pb-4 pt-6 px-6" colspan="2">Publication Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="post in posts.data" :key="post.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/posts/${post.id}`">
                {{ post.title }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/posts/${post.id}`" tabindex="-1">
                {{ post.description }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/posts/${post.id}`" tabindex="-1">
                {{ post.published_at }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/posts/${post.id}`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="posts.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No posts found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="posts.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    posts: Object,
  },
  data() {
    return {
      form: {
        search:  this.filters.search,
        order: this.filters.order,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/posts', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
