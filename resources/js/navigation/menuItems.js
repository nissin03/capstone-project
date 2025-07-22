import { LayoutDashboard, List, Package, Building2 } from "lucide-vue-next";

export const menuItems = [
    {
        name: "Dashboard",
        icon: LayoutDashboard,
        href: route("admin.dashboard"),
        active: true,
    },
    {
        name: "Categories",
        icon: List,
        children: [
            { name: "Create Category", href: "#", active: false },
            {
                name: "View Categories",
                href: route("admin.category"),
            },
        ],
    },
    {
        name: "Products",
        icon: Package,
        children: [
            { name: "Create Product", href: "#", active: false },
            { name: "View Products", href: "#", active: false },
        ],
    },
    {
        name: "Facilities",
        icon: Building2,
        children: [
            { name: "Create Facility", href: "#", active: false },
            { name: "View Facilitiies", href: "#", active: false },
        ],
    },
];
