@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Video Consultation</h4>
    <div id="jitsi-container" style="height:600px;"></div>
</div>

<script src="https://meet.jit.si/external_api.js"></script>

<script>
    const domain = "meet.jit.si";

    const options = {
        roomName: "{{ $appointment->meeting_id }}",
        width: "100%",
        height: 600,
        parentNode: document.querySelector('#jitsi-container'),
        userInfo: {
            displayName: "{{ auth()->user()->name }}"
        },
        configOverwrite: {
            prejoinPageEnabled: false
        },
        interfaceConfigOverwrite: {
            SHOW_JITSI_WATERMARK: false,
        }
    };

    const api = new JitsiMeetExternalAPI(domain, options);

    api.addEventListener('videoConferenceJoined', function () {
        fetch("{{ route('video.started', $appointment->id) }}");
    });

    api.addEventListener('videoConferenceLeft', function () {
        fetch("{{ route('video.ended', $appointment->id) }}");
    });
</script>
@endsection
