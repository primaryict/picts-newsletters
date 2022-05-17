/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */

wp.blocks.registerBlockType('picts-newsletter/page-block', {
    title: 'Display Newsletters',
    description: __( 'Show your newsletters in a block' ),
    icon: 'format-aside',
    category: 'common',
    keywords: [
        __( 'newsletter' ),
        __( 'news' ) ],
    // styles: [
    //     // Mark style as default.
    //     {
    //         name: 'default',
    //         label: __( 'Rounded' ),
    //         isDefault: true
    //     },
    //     {
    //         name: 'outline',
    //         label: __( 'Outline' )
    //     },
    //     {
    //         name: 'squared',
    //         label: __( 'Squared' )
    //     },
    // ],
    attributes: {
        content: {type: 'string'},
        color: {type: 'string'}
    },

    /* This configures how the content and color fields will work, and sets up the necessary elements */

    edit: function(props) {
        function updateContent(event) {
            props.setAttributes({content: event.target.value})
        }
        function updateColor(value) {
            props.setAttributes({color: value.hex})
        }
        return React.createElement(
            "div",
            null,
            React.createElement(
                "h3",
                null,
                "Simple Box"
            ),
            React.createElement("input", { type: "text", value: props.attributes.content, onChange: updateContent }),
            React.createElement(wp.components.ColorPicker, { color: props.attributes.color, onChangeComplete: updateColor })
        );
    },
    save: function(props) {
        return wp.element.createElement(
            "h3",
            { style: { border: "3px solid " + props.attributes.color } },
            props.attributes.content
        );
    }
})