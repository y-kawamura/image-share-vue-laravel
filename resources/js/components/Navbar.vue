<template>
  <nav class="navbar navbar-light bg-light">
    <RouterLink class="navbar-brand" to="/">
      ImageShare
    </RouterLink>
    <ul class="navbar-nav ml-auto">
      <div class="d-flex">
        <li class="nav-item">
          <span class="d-block p-2"> username </span>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link p-2" to="/signup">
            SignUp
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link p-2" to="/login">
            Login
          </RouterLink>
        </li>
      </div>
    </ul>
  </nav>
</template>

<script>
export default {};
</script>

<style></style>
