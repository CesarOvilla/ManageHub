import './bootstrap';

window.sidebarLayout = function(){
    return {
        mobileSidebarOpen: false,
        desktopSidebarOpen: true,
        isSidebarCollapsed: false,
        darkMode: false,

        // Inicializa desde localStorage
        init() {
            this.darkMode = localStorage.getItem('dark_mode') === 'true';
            this.isSidebarCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
        },

        toggleTheme() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('dark_mode', this.darkMode);
            document.documentElement.classList.toggle('dark', this.darkMode);
        },

        toggleSidebarCollapse() {
            this.isSidebarCollapsed = !this.isSidebarCollapsed;
            localStorage.setItem('sidebar_collapsed', this.isSidebarCollapsed);
        },

        toggleMobileSidebar() {
            this.mobileSidebarOpen = !this.mobileSidebarOpen;
        },

        closeMobileSidebar() {
            this.mobileSidebarOpen = false;
        }
    
    };
};
