@if ($identify_id == 'find')
    <talk-show :identify-id="{{ json_encode($identify_id) }}" :initial-user-id="{{ json_encode($user_id) }}" :era-id="{{ json_encode($era_id) }}" :team-string="{{ json_encode($team_string) }}"></talk-show>
    @else
    <talk-show :identify-id="{{ json_encode($identify_id) }}" :initial-user-id="{{ json_encode($user_id) }}"></talk-show>
    @endif