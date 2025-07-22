export default [
    {
        title: "Dashboard",
        icon: "LayoutDashboard",
        route: "admin.dashboard",
    },
    {
        title: "Catalog",
        icon: "PackageSearch",
        children: [
            { title: "Products", route: "admin.products.index" },
            { title: "Categories", route: "admin.categories.index" },
        ],
    },
    {
        title: "Facilities",
        icon: "Building2",
        children: [
            { title: "Rooms", route: "admin.facilities.rooms" },
            { title: "Reservations", route: "admin.facilities.reservations" },
        ],
    },
];
