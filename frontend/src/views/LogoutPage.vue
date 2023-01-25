<script setup>
import { inject } from "vue";

const logout = inject("ProviderLogout");
logout();
</script>
