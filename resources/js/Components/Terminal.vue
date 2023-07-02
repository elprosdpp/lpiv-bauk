<script setup>
import {io} from 'socket.io-client';
import {Terminal} from 'xterm';
import {FitAddon} from 'xterm-addon-fit';
import {WebLinksAddon} from 'xterm-addon-web-links';
import "vue-command/dist/vue-command.css";
import {onBeforeUnmount, onMounted, ref, watchEffect,} from "vue";

const socket = io('http://localhost:3000');
const curr_line = '';

const terminal = new Terminal({
    cursorBlink: true,
    fontFamily: 'Fira Code',
    cursorWidth: 2,
    cursorStyle: 'block',
    theme: {
        background: '#111827'
    }
});

onMounted(() => {


    const fitAddon = new FitAddon();
    terminal.open(document.getElementById('terminal'));
    terminal.loadAddon(fitAddon);
    terminal.loadAddon(new WebLinksAddon());
    fitAddon.fit();
    terminal.focus()

    terminal.prompt = () => {
        terminal.write('' + curr_line + '');
    };
    //
    terminal.prompt();

    socket.on('output', (data) => {
        terminal.write(data);
    });

    terminal.onKey((e) => {
        const propmt = e.key;
        socket.emit('input', propmt)

        const charCode = e.domEvent.keyCode;
        const isCtrlPressed = e.domEvent.ctrlKey;
        const isShiftPressed = e.domEvent.shiftKey;

        // Perintah "paste"
        if (isCtrlPressed && charCode === 86) { // Ctrl + V
            // Dapatkan konten dari clipboard
            const pasteContent = window.navigator.clipboard.readText();

            // Lakukan sesuatu dengan konten yang ditempelkan
            pasteContent.then((content) => {
                // Manipulasi konten yang ditempelkan sesuai kebutuhan
                socket.emit('input', content)
                console.log('Pasted content:', content);
            });
        }
    })
});

onBeforeUnmount(() => {
    terminal.dispose()
})

</script>

<template>
    <div>
        <div id="terminal"></div>
    </div>
</template>

