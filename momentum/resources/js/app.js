import './bootstrap';
import timers from './timers';
timers();
import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.sidebar = function () {
    return {
        expanded: false,
        init() {
            this.expanded = JSON.parse(localStorage.getItem('sidebar_expanded')) ?? false;
            this.$watch('expanded', val => {
                localStorage.setItem('sidebar_expanded', JSON.stringify(val));
            });
        },
        toggle() {
            this.expanded = !this.expanded;
        }
    }
};

Alpine.start();