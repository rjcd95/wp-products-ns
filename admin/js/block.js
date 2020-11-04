var registerBlockType = wp.blocks.registerBlockType;
var el = wp.element.createElement;
var serverSideRender = wp.serverSideRender;

registerBlockType("gutenberg-block/produts-block", {
    title: "Products",
    icon: "feedback",
    category: "common",
    edit: function() {
        return el(
            "div", {
                className: "block",
            },
            el("h4", "block-title", "Products")
        );
    },
    save: () => {},
});

registerBlockType("gutenberg-block/brands-block", {
    title: "Brands",
    icon: "feedback",
    category: "common",
    edit: function() {
        return el(
            "div", {
                className: "block",
            },
            el("h4", "block-title", "Brands")
        );
    },
    save: () => {},
});