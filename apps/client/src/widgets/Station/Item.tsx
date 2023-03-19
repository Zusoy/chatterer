import React from 'react';
import { Station } from 'models/Station';
import OverlayTrigger from 'react-bootstrap/OverlayTrigger';
import Tooltip from 'react-bootstrap/Tooltip';
import styled from 'styled-components';

interface Props {
  station: Station;
  onSelect: (station: Station) => void;
}

const Item: React.FC<Props> = ({ station, onSelect }) => {
  const name: string = station.name.slice(0, 1).toUpperCase();

  return (
    <OverlayTrigger
      key={ station.id }
      placement='right'
      overlay={
        <Tooltip id={ 'tooltip-right' }>
          { station.name }
        </Tooltip>
      }
    >
      <StationItem onClick={ () => onSelect(station) }>
        { name }
      </StationItem>
    </OverlayTrigger>
  );
}

const StationItem = styled.div(({ theme }) => `
  transition: background 0.5s;
  position: relative;
  width: 50px;
  height: 50px;
  border-radius: 50px;
  border: solid 1px ${theme.colors.white};
  background-color: ${theme.colors.dark80};
  color: ${theme.colors.white};
  text-align: center;
  padding: 11px;
  cursor: pointer;

  &:hover {
    color: ${theme.colors.dark80};
    background-color: ${theme.colors.purple};
  }
`);

export default Item;
