import React, { useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import stations, { selectStations } from 'features/StationsSidebar/slice';
import styled from 'styled-components';
import Item from 'widgets/Station/Item';

const List: React.FC = () => {
  const dispatch = useDispatch();
  const items = useSelector(selectStations);

  useEffect(() => {
    dispatch(stations.actions.fetchList());
  }, [ dispatch ]);

  return (
    <Wrapper>
      { items.map(
        station =>
          <Item
            station={ station }
            onSelect={ target => dispatch(stations.actions.select(target.id)) }
          />
      ) }
    </Wrapper>
  );
}

const Wrapper = styled.div(({ theme }) => `
  display: flex;
  flex-direction: column;
  gap: ${theme.gap.m};
  margin: ${theme.gap.m};
  align-items: center;
`);

export default List;
