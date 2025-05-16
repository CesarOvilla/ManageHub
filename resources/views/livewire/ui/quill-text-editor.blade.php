@php
    $readOnly = $readOnly ?? false; // Si no está definido, usa false por defecto
@endphp
<div wire:ignore>
    <div id="{{ $quillId }}"></div>
</div>


@script

    <script>
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],
            ['link', 'formula','image'],
            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],

            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }], // superscript/subscript
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }], // outdent/indent

            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'font': []
            }],
            [{
                'align': []
            }],

            ['clean'] // remove formatting button
        ];
        const quill = new Quill('#' + @js($quillId), {
            theme: @js($theme),
            readOnly:@js($readOnly),
            modules: {
                // syntax: true,
                toolbar: @js($readOnly) ? null : toolbarOptions,
            },
        });

        const Delta = Quill.import('delta');
        quill.setContents(
            new Delta()
            .insert('const language = "JavaScript";')
            .insert('\n', {
                'code-block': 'javascript'
            })
            .insert('console.log("I love " + language + "!");')
            .insert('\n', {
                'code-block': 'javascript'
            })
        );

        quill.root.innerHTML = $wire.get('value');

        quill.on('text-change', function() {
            let value = quill.root.innerHTML;
            @this.set('value', value);
        });
    </script>
@endscript
