<script setup>
const model = defineModel({ type: Boolean, default: false })
</script>

<template>

    <label class="toggle-switch">
        <input type="checkbox">
        <div class="toggle-switch-background">
            <div class="toggle-switch-handle"></div>
        </div>
    </label>
</template>

<style scoped>
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    cursor: pointer;
}

.toggle-switch input[type="checkbox"] {
    display: none;
}

.toggle-switch-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #ddd;
    border-radius: 20px;
    box-shadow: inset 0 0 0 2px #ccc;
    transition: background-color 0.3s ease-in-out;
}

.toggle-switch-handle {
    position: absolute;
    top: 5px;
    left: 5px;
    width: 30px;
    height: 30px;
    background-color: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}

.toggle-switch::before {
    content: "";
    position: absolute;
    top: -25px;
    right: -35px;
    font-size: 12px;
    font-weight: bold;
    color: #aaa;
    text-shadow: 1px 1px #fff;
    transition: color 0.3s ease-in-out;
}

.toggle-switch input[type="checkbox"]:checked+.toggle-switch-handle {
    transform: translateX(45px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2), 0 0 0 3px #05c46b;
}

.toggle-switch input[type="checkbox"]:checked+.toggle-switch-background {
    background-color: #05c46b;
    box-shadow: inset 0 0 0 2px #04b360;
}

.toggle-switch input[type="checkbox"]:checked+.toggle-switch:before {
    content: "On";
    color: #05c46b;
    right: -15px;
}

.toggle-switch input[type="checkbox"]:checked+.toggle-switch-background .toggle-switch-handle {
    transform: translateX(40px);
}
</style>
