<script setup>
import { ref } from 'vue'

import 'filepond/dist/filepond.min.css'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'
const emit = defineEmits(['uploaded', 'removed', 'uploading'])

import FilePond from '@/utils/filepond'
const files = ref([])

const props = defineProps({
    multiple: {
        type: Boolean,
        default: false
    },
    maxFiles: {
        type: Number,
        default: 1,
    },
    files: {
        type: Array,
        default: () => [],
    },
})
const updateFileList = (fileItems) => {
    if (fileItems.length > 0 && fileItems.some(f => f.status !== 5)) {
        emit('uploading', true)
    }
    files.value = fileItems
    emit('uploading', fileItems.length > 0)
}

const onProcessFile = (error, file) => {
    emit('uploading', false)

    if (!error && file.serverId) {
        emit('uploaded', file.serverId)
    } else if (error) {
        console.error('File processing error:', error);
    }
}

const isReplacing = ref(false)

const onRemoveFile = (error, file) => {
    if (error) {
        console.error('File removal error:', error);
        return
    }

    if (isReplacing.value) {
        console.log('File replaced during upload, skip manual removal emit.')
        isReplacing.value = false
        return
    }

    console.log('File removed manually')
    emit('removed')
}

const serverConfig = {
    process: {
        url: '/admin/uploads',
        method: 'POST',
        withCredentials: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        onload: (response) => {
            console.log('Upload response received:', response);
            try {
                const data = JSON.parse(response)
                console.log('Parsed response data:', data);
                return data.path
            } catch (e) {
                console.error('Failed to parse upload response:', e);
                return response
            }
        },
        onerror: (response) => {
            console.error('Upload error:', response);
        }
    },
    revert: {
        url: '/admin/uploads/revert',
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    }
}
</script>

<template>
    <FilePond :imageResizeTargetWidth="800" :imageResizeTargetHeight="800" imageResizeMode="contain"
        imageTransformOutputMimeType="image/jpeg" imageTransformOutputQuality="0.7" name="image" :files="props.files"
        :server="serverConfig" :allow-multiple="props.multiple" :max-files="props.maxFiles"
        accepted-file-types="image/png, image/jpeg" :image-preview-height="200"
        label-idle="Drag & Drop your image or <span class='filepond--label-action'>Browse</span>"
        @updatefiles="updateFileList" @processfile="onProcessFile" @removefile="onRemoveFile" />

</template>
