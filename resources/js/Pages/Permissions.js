import { usePage } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

export const auth = ref({

  hasPermission(permission) {
    if (usePage().props.value.auth.user.role == 'Super Admin') {
      return true
    }
    return usePage().props.value.auth.user.permissions.includes(permission)
  },

  hasRole(role) {
    if (usePage().props.value.auth.user.role == 'Super Admin') {
      return true
    }
    return usePage().props.value.auth.user.role == role
  },

  hasAnyPermission(permissions) {
    if (usePage().props.value.auth.user.role == 'Super Admin') {
      return true
    }
    return permissions.some((permission) => usePage().props.value.auth.user.permissions.includes(permission))
  },

  hasAnyRole(roles) {
    if (usePage().props.value.auth.user.role == 'Super Admin') {
      return true
    }
    return roles.some((role) => usePage().props.value.auth.user.role == role)
  },

});
